<?php

namespace App\Models\Customs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'receipt_number',
        'receipt_date',
        'goods_code',
        'goods_name_1',
        'goods_name_2',
        'unit',
        'quantity',
        'valas',
        'value',
        'annotation_1',
        'annotation_2',
    ];

    protected $casts = [
        'receipt_date' => 'date:d/m/Y',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
