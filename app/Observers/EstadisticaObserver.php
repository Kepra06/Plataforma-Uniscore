<?php

namespace App\Observers;

use App\Models\Estadistica;
use App\Models\EstadisticaEquipo;

class EstadisticaObserver
{
    /**
     * Se ejecuta cuando se crea una nueva estadística.
     */
    public function created(Estadistica $estadistica)
    {
        $this->updateTeamTotalGoals($estadistica);
    }

    /**
     * Se ejecuta cuando se actualiza una estadística.
     */
    public function updated(Estadistica $estadistica)
    {
        $this->updateTeamTotalGoals($estadistica);
    }

    /**
     * Se ejecuta cuando se elimina una estadística.
     */
    public function deleted(Estadistica $estadistica)
    {
        $this->updateTeamTotalGoals($estadistica);
    }

    /**
     * Función que recalcula el total de goles de un equipo en un partido y
     * actualiza (o crea) el registro en la tabla estadisticas_equipo.
     */
    protected function updateTeamTotalGoals(Estadistica $estadistica)
{
    // Verificamos que la estadística tenga un jugador asociado
    if (!$estadistica->jugador) {
        return;
    }

    $equipoId = $estadistica->jugador->equipo_id;
    $partidoId = $estadistica->partido_id;

    // Sumar todos los goles de los jugadores de ese equipo en el partido
    $total = Estadistica::whereHas('jugador', function ($query) use ($equipoId) {
        $query->where('equipo_id', $equipoId);
    })->where('partido_id', $partidoId)->sum('goals');

    // Actualizar o crear el registro en estadisticas_equipo
    EstadisticaEquipo::updateOrCreate(
        [
            'equipo_id'   => $equipoId,
            'partido_id'  => $partidoId,
        ],
        [
            'total_goals' => $total,
        ]
    );
}

}
