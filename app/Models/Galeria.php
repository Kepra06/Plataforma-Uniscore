<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;

    protected $table = 'galeria'; // Especifica el nombre de la tabla

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'type',
        'user_id',
    ];
}
