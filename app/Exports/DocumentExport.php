<?php

namespace App\Exports;

use App\Models\Customs\Document;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocumentExport implements FromQuery, WithMapping
{
    private $transactionType, $documentType, $startDate, $endDate;

    public function __construct($transactionType, $documentType, $startDate, $endDate)
    {
        $this->transactionType = $transactionType;
        $this->documentType = $documentType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Document::where('transaction_type', $this->transactionType)
            ->where('doc_type', $this->documentType)
            ->whereBetween('doc_date', [$this->startDate, $this->endDate])
            ->with('items');
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->doc_type
        ];
    }
}
