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

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->where('transaction_type', $filters['transaction_type'])
            ->where('doc_type', $filters['doc_type'])
            ->whereBetween('doc_date', [$filters['start_date'], $filters['end_date']])
            ->when($filters['vendor'] ?? null, function ($query, $search) {
                $query->where('vendor', 'like', '%'.$search.'%');
            })
            ->whereHas('items', function ($query) use ($filters) {
                $query
                    ->when($filters['goods_code'] ?? null, function ($query, $search) {
                        $query->where('goods_code', 'like', '%'.$search.'%');
                    })
                    ->when($filters['goods_name'] ?? null, function ($query, $search) {
                        $query->where('goods_name_1', 'like', '%'.$search.'%')
                            ->orWhere('goods_name_2', 'like', '%'.$search.'%');
                    });
            });
    }
}
