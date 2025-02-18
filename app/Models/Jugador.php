<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    use HasFactory;

    protected $table = 'jugadores';

    protected $fillable = [
        'name',
        'equipo_id',
        'number',
        'position',
    ];

    /**
     * Relación con el modelo Equipo.
     * Un jugador pertenece a un equipo.
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    /**
     * Relación con el modelo Estadistica.
     * Un jugador tiene muchas estadísticas.
     */
    public function estadisticas()
    {
        return $this->hasMany(Estadistica::class);
    }
}
