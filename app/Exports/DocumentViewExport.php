<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DocumentViewExport implements FromView, WithColumnFormatting
{
    private $transactionType, $models, $headings;

    public function __construct($request, $models, $headings)
    {
        $this->transactionType = $request->transaction_type;
        $this->models = $models;
        $this->headings = $headings;
    }

    public function view(): View
    {
        return view('exports.document', [
            'transaction_type' => $this->transactionType,
            'documents' => $this->models,
            'headings' => $this->headings,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'N' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }
}
