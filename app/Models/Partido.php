<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;

    protected $fillable = [
        'torneo_id',
        'equipo_local_id',
        'equipo_visitante_id',
        'match_date',
        'match_time',
        'local_score',
        'visitor_score',
        'location',
        'ganador_id',
        'ronda',
        'resultado_final',
    ];

    // Relaciones
    public function torneo()
    {
        return $this->belongsTo(Torneo::class);
    }

    public function equipoLocal()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    public function equipoVisitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    public function ganador()
    {
        return $this->belongsTo(Equipo::class, 'ganador_id');
    }

    public function estadisticas()
    {
        return $this->hasMany(EstadisticaEquipo::class, 'partido_id');
    }

    // Método para determinar el ganador del partido
    public function determinarGanador()
    {
        if (!is_null($this->local_score) && !is_null($this->visitor_score)) {
            $this->ganador_id = match (true) {
                $this->local_score > $this->visitor_score => $this->equipo_local_id,
                $this->visitor_score > $this->local_score => $this->equipo_visitante_id,
                default => null,
            };

            $this->resultado_final = "{$this->local_score}-{$this->visitor_score}";
            $this->save();
        }
    }

    // Scope para filtrar partidos ganados por un equipo
    public function scopePartidosGanadosPorEquipo($query, $equipoId)
    {
        return $query->where('ganador_id', $equipoId);
    }

    // Setter para validar y asignar el valor de la ronda
    public function setRondaAttribute($value)
    {
        $valoresPermitidos = [
            'Primera Ronda', 
            'Octavos de Final',
            'Cuartos de Final', 
            'Semifinales', 
            'Final'
        ];
        $this->attributes['ronda'] = in_array($value, $valoresPermitidos) ? $value : null;
    }
}
