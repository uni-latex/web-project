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
        'temp_file',
        'original_file',
        'file_size',
        'user_id',
        'is_success',
        'exception',
    ];

    protected $casts = [
        'file_date' => 'date',
        'is_success' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
