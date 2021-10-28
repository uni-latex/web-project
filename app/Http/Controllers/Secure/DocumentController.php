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

        $ignores = ['per_page', 'start_date', 'end_date'];

        $filters = $this->filters($request);

        $documents = Document::query()
            ->orderBy('doc_date', 'desc');

        foreach($filters as $filter => $value) {
            if (in_array($filter, $ignores)) continue;
            $documents->where($filter, $value);
        }

        $documents->whereBetween('doc_date', [$filters['start_date'], $filters['end_date']]);

        $documents = $documents
            ->with('items')
            ->paginate($filters['per_page'])
            ->withQueryString();        // fungsi ini digunakan agar query lain ditambahkan untuk pagination links

        return Inertia::render('Secure/Document/Index', [
            'filters' => $filters,
            'documents' => $documents,
        ]);
    }

    private function filters(Request $request)
    {
        $filters = [
            'transaction_type' => 1,
            'doc_type' => "BC2.3",
            'start_date' => now()->subMonths(2)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
            'per_page' => 25,
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

        $transaction_type = $request->transaction_type;
        $doc_type = $request->doc_type;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $transaksi = $transaction_type == 1 ? "PEMASUKAN" : "PENGELUARAN";
        $headingStartDate = Carbon::parse($startDate)->format('d F Y');
        $headingEndDate = Carbon::parse($endDate)->format('d F Y');
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

        $documents = Document::where('transaction_type', $transaction_type)
            ->where('doc_type', $doc_type)
            ->whereBetween('doc_date', [$startDate, $endDate])
            ->with('items')
            ->get();

        return Excel::download(
            new DocumentViewExport($request, $documents, $headings),
            $filename
        );
    }
}
