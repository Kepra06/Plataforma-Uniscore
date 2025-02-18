<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sport_type',
        'tournament_type',
        'number_of_teams',
        'start_date',
        'end_date',
    ];

    /**
     * Relación con el modelo Equipo
     * Un torneo tiene muchos equipos.
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    /**
     * Relación con el modelo Partido
     * Un torneo tiene muchos partidos.
     */
    public function partidos()
    {
        return $this->hasMany(Partido::class);
    } 
}
