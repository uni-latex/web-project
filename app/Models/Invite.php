<?php

namespace App\Models;

use App\Notifications\SendUserInvitation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invite extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'bool',
        'used_at' => 'date',
        'expired_at' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($invite) {

            $invite->notify(new SendUserInvitation());

        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
