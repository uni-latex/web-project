<?php


namespace App\Imports;


use App\Models\Customs\Document;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DocumentImport implements ToCollection, WithStartRow
{
    private $uploadModel, $document_type, $transaction_type;

    public function __construct($model, $document_type, $transaction_type)
    {
        $this->uploadModel = $model;

        $this->document_type = $document_type;

        $this->transaction_type = $transaction_type;
    }

    public function collection(Collection $collection)
    {
        // hapus dokumen yang sudah pernah di import dengan data yang sama
        $this->removeDocument($collection);

        foreach ($collection as $row) {

            // jika kolom jenis dok kosong tidak perlu import
            if ($row[1]) {
                $doc_date = Date::excelToDateTimeObject($row[3])->format('Y-m-d');

                $document = Document::where('doc_number', $this->formatDocumentNumber($row[2]))
                    ->where('doc_type', $this->document_type)
                    ->where('doc_date', $doc_date)
                    ->where('transaction_type', $this->transaction_type)
                    ->first();

                if (! $document) {

                    $document = $this->createDocument($row);
                }

                $this->createDocumentItem($document, $row);
            }
        }
    }

    private function removeDocument($collection)
    {
//        $this->removeDocumentByDate($collection);
        $this->removeDocumentByDocTypeAndDate($collection);
        $this->removeDocumentByNumberAndDocType($collection);
    }

    private function removeDocumentByDocTypeAndDate($collection)
    {
        $docDates = $collection->map(function ($row) {
            if ($row[3]) return Date::excelToDateTimeObject($row[3])->format('Y-m-d');
        })->unique();

        Document::whereIn('doc_date', $docDates)
            ->where('doc_type', $this->document_type)
            ->where('transaction_type', $this->transaction_type)
            ->delete();
    }

    private function removeDocumentByNumberAndDocType($collection)
    {
        $docNumbers = $collection->map(function ($row) {
            if ($row[2]) return $this->formatDocumentNumber($row[2]);
        })->unique();

        Document::whereIn('doc_number', $docNumbers)
            ->where('doc_type', $this->document_type)
            ->where('transaction_type', $this->transaction_type)
            ->delete();
    }

    private function createDocument($row)
    {
        $document = Document::create([
            //'transaction_type' => $this->documentTransactionId($this->model->transaction_type),
            'transaction_type' => $this->transaction_type,
            //'doc_type' => $row[1],
            'doc_type' => $this->document_type,
            'doc_number' => $this->formatDocumentNumber($row[2]),
            'doc_date' => Date::excelToDateTimeObject($row[3]),
            'vendor' => $row[6],
        ]);

        return $document;
    }

    private function formatDocumentNumber($doc_number)
    {
        if (strlen($doc_number) > 6) {
            $doc_number = substr($doc_number, 0, 6);
        }
        return $doc_number;
    }

    private function createDocumentItem($document, $row)
    {
        $document->items()->create([
            'receipt_number' => $row[4],
            'receipt_date' => empty($row[5]) ? Date::excelToDateTimeObject($row[3]) : Date::excelToDateTimeObject($row[5]),
//            'receipt_date' => Date::excelToDateTimeObject($row[3]),
            'goods_code' => $row[7],
            'goods_name_1' => $row[8],
            'goods_name_2' => $row[9],
            'unit' => $row[10],
            'quantity' => $row[11],
            'valas' => $row[12],
            'value' => $row[13],
            'annotation_1' => $row[14] ?? null,
            'annotation_2' => $row[15] ?? null,
        ]);
    }

    public function startRow(): int
    {
        return 12;
    }
}
