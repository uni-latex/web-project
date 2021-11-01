<?php

namespace App\Models\Customs;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'file_model',
        'file_date',
        'original_file',
        'file_size',
        'user_id',
        'is_success',
        'exception',

        //php artisan nova:resource
    ];

    protected $casts = [
        'file_date' => 'date',
        'is_success' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['upload_type'] ?? null,function ($query, $search) {
                $query->where('type', $search);
            });
    }
}
