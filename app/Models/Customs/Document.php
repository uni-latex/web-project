<?php

namespace App\Models\Customs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'doc_type',
        'doc_number',
        'doc_date',
        'vendor',
    ];

    protected $casts = [
        'doc_date' => 'date:d/m/Y',
    ];

    public function items()
    {
        return $this->hasMany(DocumentItem::class);
    }
}
