<?php


namespace App\Exports;


use App\Models\Customs\DocumentItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class DocumentItemExport implements FromQuery, WithMapping, WithCustomStartCell, WithHeadings
{
    private $transactionType, $documentType, $startDate, $endDate;

    public function __construct($transactionType, $documentType, $startDate, $endDate)
    {
        $this->transactionType = $transactionType;
        $this->documentType = $documentType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return DocumentItem::whereHas('document', function ($query) {
            $query->where('transaction_type', $this->transactionType)
                ->where('doc_type', $this->documentType)
                ->whereBetween('doc_date', [$this->startDate, $this->endDate]);
        });
    }

    public function map($row): array
    {
        return [
            $row->document->doc_type,
            $row->document->doc_number,
            $row->document->doc_date,
            $row->receipt_number,
            $row->receipt_date,
            $row->vendor,
            $row->goods_code,
            $row->goods_name_1,
            $row->goods_name_2,
            $row->unit,
            $row->quantity,
            $row->valas,
            $row->value,
            $row->annotation_1,
            $row->annotation_2,
        ];
    }

    public function startCell(): string
    {
        return "A12";
    }

    public function headings(): array
    {
        return [
            "Jenis Dokumen",
            "Nomor",
            "Tanggal",
            "Nomor",
            "Tanggal",
            "Pemasok / Pengirim",
            "Kode Barang",
            "Nama Barang 1",
            "Nama Barang 2",
            "Satuan",
            "Jumlah",
            "Valas",
            "Nilai Barang",
            "Keterangan 1",
            "Keterangan 2",
        ];
    }
}
