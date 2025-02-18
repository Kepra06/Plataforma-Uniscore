<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileTrainee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'position',
        'experience_level',
        'phone',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
