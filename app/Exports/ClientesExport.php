<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientesExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    /**
     * Exporta la colección de clientes.
     */
    public function collection()
    {
        return Cliente::select(
            'codigo', 
            'cedula', 
            'nombre_razon_social', 
            'tipo_tercero', 
            'celular', 
            'telefono', 
            'correo_principal', 
            'departamento', 
            'ciudad', 
            'direccion', 
            'referencia'
        )->get();
    }

    /**
     * Definir las cabeceras de las columnas.
     */
    public function headings(): array
    {
        return [
            'Código', 
            'Cédula/NIT', 
            'Nombre o Razón Social', 
            'Tipo de Tercero', 
            'Celular', 
            'Teléfono', 
            'Correo', 
            'Departamento', 
            'Ciudad', 
            'Dirección', 
            'Referencia'
        ];
    }

    /**
     * Establecer el nombre de la hoja.
     */
    public function title(): string
    {
        return 'Clientes';
    }

    /**
     * Aplicar estilos a la hoja de cálculo.
     */
    public function styles(Worksheet $sheet)
    {
        // Aplicar estilo azul a las cabeceras
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // Texto blanco
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF2196F3'], // Color azul (#2196F3)
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Aplicar borde a todas las celdas
        $sheet->getStyle('A1:K' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Color negro para los bordes
                ],
            ],
        ]);

        // Ajustar el tamaño automático de las columnas
        foreach(range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Alinear datos de forma centrada
        $sheet->getStyle('A2:K' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center');
    }
}
