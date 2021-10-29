<?php

namespace App\Http\Controllers\Secure;


use App\Exports\DocumentViewExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Customs\Document;
use Maatwebsite\Excel\Facades\Excel;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::user()->can('viewDocuments')) {
            return Redirect::route('dashboard');
        }

        $filters = $this->filters($request);

        $models = Document::query()
            ->filter($filters)
            ->with('items')
            ->paginate(25)
            ->withQueryString();        // fungsi ini digunakan agar query lain ditambahkan untuk pagination links

        return Inertia::render('Secure/Document/Index', [
            'fields' => [
                'transaction_types' => config('customs.documents.transaction_types'),
                'document_types' => config('customs.documents.document_types'),
            ],
            'filters' => $filters,
            'models' => $models,
        ]);
    }

    private function filters(Request $request)
    {
        $filters = [
            'transaction_type' => array_key_first(config('customs.documents.transaction_types')),
            'doc_type' => array_key_first(config('customs.documents.document_types')),
            'start_date' => now()->subMonths(2)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'goods_code' => '',
            'goods_name' => '',
            'vendor' => '',
        ];

        foreach ($filters as $key => $value) {
            $filters[$key] = $request->get($key) ?? $filters[$key];
        }

        return $filters;
    }

    public function download(Request $request)
    {
        if (! Auth::user()->can('downloadDocuments')) {
            return Redirect::route('documents');
        }

        $filters = $this->filters($request);

        $transaksi = $filters['transaction_type'] == 1 ? "PEMASUKAN" : "PENGELUARAN";
        $headingStartDate = Carbon::parse($filters['start_date'])->format('d F Y');
        $headingEndDate = Carbon::parse($filters['end_date'])->format('d F Y');
        $companyName = strtoupper(config('app.name'));
        $headings = [
            "DEPARTEMEN KEUANGAN REPUBLIK INDONESIA",
            "DIREKTORAT JENDERAL BEA DAN CUKAI",
            "KANTOR WILAYAH SUMATERA UTARA",
            "KANTOR PENGAWASAN DAN PELAYANAN TIPE MADYA PABEAN BELAWAN",
            "",
            "A. LAPORAN {$transaksi} BARANG PER DOKUMEN PABEAN",
            "KAWASAN BERIKAT PT. {$companyName}",
            "   LAPORAN {$transaksi} BARANG PER DOKUMEN PABEAN",
            "   PERIODE PELAPORAN :  {$headingStartDate} - {$headingEndDate}",
            "",
        ];

        $filename = "LAPORAN {$transaksi} BARANG PER DOKUMEN PABEAN.xls";

        $documents = Document::query()
            ->filter($filters)
            ->with('items')
            ->get();

        return Excel::download(
            new DocumentViewExport($request, $documents, $headings),
            $filename
        );
    }
}
