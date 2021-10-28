<?php


namespace App\Models\Customs;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
