<?php


namespace App\Models\Customs;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Mutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_code',
        'goods_name',
        'mutation_date',
        'unit',
        'beginning_balance',
        'entering',
        'spending',
        'compliance',
        'final_balance',
        'stock_opname',
        'difference',
        'annotation',
    ];

    protected $casts = [
        'mutation_date' => 'date',
    ];

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->whereBetween('mutation_date', [$filters['start_date'], $filters['end_date']])
            ->when($filters['goods_code'] ?? null, function ($query, $search) {
                $query->where('goods_code', 'like', '%' . $search . '%');
            })
            ->when($filters['goods_name'] ?? null, function ($query, $search) {
                $query->where('goods_name', 'like', '%'.$search.'%');
            });
    }
}
