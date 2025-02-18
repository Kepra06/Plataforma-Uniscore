<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCoach extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'experience',
        'specialty',
        'phone',
        'email',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
