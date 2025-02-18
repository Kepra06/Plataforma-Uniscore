<?php

namespace App\Imports;

use App\Models\Cliente;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientesImport implements ToModel, WithHeadingRow
{
    /**
     * Crea o actualiza una instancia de Cliente por cada fila importada.
     */
    public function model(array $row)
    {
        // Log para depurar qué datos se están importando
        Log::info('Datos de la fila importada:', $row);

        // Verificamos si los campos obligatorios tienen valores
        if (!isset($row['cedulanit']) || empty($row['cedulanit'])) {
            return null; // Ignorar esta fila si 'cedulanit' está vacío
        }

        // Buscar cliente por 'codigo'
        $cliente = Cliente::where('codigo', $row['codigo'])->first();

        // Si el cliente ya existe, actualizamos sus datos
        if ($cliente) {
            $cliente->update([
                'cedula' => $row['cedulanit'],
                'nombre_razon_social' => $row['nombre_o_razon_social'],
                'tipo_tercero' => $row['tipo_de_tercero'],
                'celular' => $row['celular'],
                'telefono' => $row['telefono'],
                'correo_principal' => $row['correo'],
                'departamento' => $row['departamento'],
                'ciudad' => $row['ciudad'],
                'direccion' => $row['direccion'],
                'referencia' => $row['referencia'],
            ]);

            // Retornar null para evitar intentar insertar de nuevo
            return null;
        }

        // Si el cliente no existe, lo creamos
        return new Cliente([
            'codigo' => $row['codigo'],
            'cedula' => $row['cedulanit'],
            'nombre_razon_social' => $row['nombre_o_razon_social'],
            'tipo_tercero' => $row['tipo_de_tercero'],
            'celular' => $row['celular'],
            'telefono' => $row['telefono'],
            'correo_principal' => $row['correo'],
            'departamento' => $row['departamento'],
            'ciudad' => $row['ciudad'],
            'direccion' => $row['direccion'],
            'referencia' => $row['referencia'],
        ]);
    }
}
