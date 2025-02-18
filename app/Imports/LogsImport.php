<?php

namespace App\Imports;

use App\Models\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LogsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Depurar para verificar los datos recibidos
        // dd($row);

        return new Log([
            'nombre' => $row['nombre'],
            'factura' => $row['factura'],
            'telefono' => !empty($row['telefono']) ? $row['telefono'] : null, // Manejo de nulos
            'fecha' => \Carbon\Carbon::parse($row['fecha']),
            'user_id' => $row['user_id'],
            'cliente_id' => $row['cliente_id'],
        ]);
    }
}
