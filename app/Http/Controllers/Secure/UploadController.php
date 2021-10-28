<?php

namespace App\Http\Controllers\Secure;

use App\Http\Controllers\Controller;
use App\Imports\DocumentImport;
use App\Imports\MutationImport;
use App\Models\Customs\BahanBakuDanPenolong;
use App\Models\Customs\BarangDalamProses;
use App\Models\Customs\BarangJadi;
use App\Models\Customs\BarangSisaDanScrap;
use App\Models\Customs\BarangSparepart;
use App\Models\Customs\Document;
use App\Models\Customs\MesinDanPeralatanKantor;
use App\Models\Customs\Upload;
use App\Rules\DocumentRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->can('uploadDocument') || Auth::user()->can('uploadMutation')) {
            return Inertia::render('Secure/Upload/Index');
        }

        return Redirect::route('dashboard');
    }

    public function upload(Request $request)
    {
        if (! Auth::user()->can('uploadDocument') || ! Auth::user()->can('uploadMutation')) {
            return Redirect::route('dashboard');
        }

        $method = "upload" . $request->type;

        return $this->{$method}($request);
    }

    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document_file' => ['required', 'file', new DocumentRule('/^(bc)/i')]
        ], [
            'document_file.required' => 'Pilih file dokumen pabean'
        ]);

        $file = $request->document_file;

        $originalFile = $file->getClientOriginalName();

        if (! preg_match("/\(in|out\)/i", $originalFile)) {
            throw ValidationException::withMessages([
                'document_file' => 'File dokumen pabean salah',
            ]);
        }

        $storageFile = Storage::put('customs', $file);

        [$document_type, $transaction_type] = $this->parseDocumentFilename($originalFile);

        $upload = Upload::create([
            'type' => $request->type,
            'file_model' => Document::class,
            'temp_file' => $storageFile,
            'original_file' => $originalFile,
            'file_size' => $file->getSize(),
            'user_id' => Auth::user()->id,
        ]);

        try {
            Excel::import(new DocumentImport($upload, $document_type, $transaction_type), $storageFile);
            $upload->update([
                'is_success' => true,
            ]);
            $request->session()->flash('success', "File {$originalFile} berhasil di upload.");
        } catch (\Exception $exception) {
            $upload->update([
                'exception' => $exception->getMessage(),
            ]);
            $request->session()->flash('error', "File {$originalFile} gagal di upload!");
        }

        Storage::delete($storageFile);

        return Redirect::route('upload');
    }

    public function uploadMutation(Request $request)
    {
        $request->validate([
            'mutation_type' => ['required'],
            'mutation_date' => ['required'],
            'mutation_file' => ['required', 'file'],
        ], [
            'mutation_type.required' => 'Pilih dokumen mutasi',
            'mutation_date.required' => 'Pilih tanggal mutasi',
            'mutation_file.required' => 'Pilih file dokumen mutasi',
        ]);

        $file = $request->mutation_file;

        $originalFile = $file->getClientOriginalName();

        $storageFile = Storage::put('customs', $file);

        $upload = Upload::create([
            'type' => $request->type,
            'file_model' => $this->mutationModel($request->mutation_type),
            'file_date' => $request->mutation_date,
            'temp_file' => $storageFile,
            'original_file' => $originalFile,
            'file_size' => $file->getSize(),
            'user_id' => Auth::user()->id,
        ]);

        try {
            Excel::import(new MutationImport($upload), $storageFile);

            $upload->update([
                'is_success' => true,
            ]);

            $request->session()->flash('success', "File {$originalFile} berhasil di upload.");

        } catch (\Exception $exception) {
            $upload->update([
                'exception' => $exception->getMessage(),
            ]);

            $request->session()->flash('error', "File {$originalFile} gagal di upload!");
        }

        Storage::delete($storageFile);

        return Redirect::route('upload');
    }

    private function mutationModel($mutation_type)
    {
        $models = [
            'bbp' => BahanBakuDanPenolong::class,
            'bdp' => BarangDalamProses::class,
            'bj' => BarangJadi::class,
            'bs' => BarangSparepart::class,
            'bsds' => BarangSisaDanScrap::class,
            'mdpk' => MesinDanPeralatanKantor::class,
        ];

        return $models[$mutation_type];
    }

    private function parseDocumentFilename($filename)
    {
        $filename = strtoupper($filename);
        // parse karater in = 1, out = 0
        $transaction_type = $this->get_string_between($filename, '(', ')') === 'IN' ? 1 : 0;
        // prase BC. 23 menjadi BC23
        $document_type = str_replace([' ', '.'], '', trim(substr($filename, 0,strpos($filename, '('))));
        // tambahkan . menjadi BC2.3
        $document_type = substr_replace($document_type, '.', 3, 0);

        return [$document_type, $transaction_type];
        //return "{$document_type}|$transaction_type";
    }

    private function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
