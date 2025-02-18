<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepartmentAndCity;

class DepartmentAndCitySeeder extends Seeder
{
    public function run()
    {
        $departmentsAndCities = [
            // Amazonas
            ['department' => 'Amazonas', 'city' => 'Leticia'],

            // Antioquia
            ['department' => 'Antioquia', 'city' => 'Medellín'],
            ['department' => 'Antioquia', 'city' => 'Envigado'],
            ['department' => 'Antioquia', 'city' => 'Itagüí'],
            ['department' => 'Antioquia', 'city' => 'Bello'],

            // Arauca
            ['department' => 'Arauca', 'city' => 'Arauca'],
            ['department' => 'Arauca', 'city' => 'Saravena'],

            // Atlántico
            ['department' => 'Atlántico', 'city' => 'Barranquilla'],
            ['department' => 'Atlántico', 'city' => 'Soledad'],
            ['department' => 'Atlántico', 'city' => 'Malambo'],

            // Bolívar
            ['department' => 'Bolívar', 'city' => 'Cartagena'],
            ['department' => 'Bolívar', 'city' => 'Magangué'],
            ['department' => 'Bolívar', 'city' => 'Turbaco'],

            // Boyacá
            ['department' => 'Boyacá', 'city' => 'Tunja'],
            ['department' => 'Boyacá', 'city' => 'Duitama'],
            ['department' => 'Boyacá', 'city' => 'Sogamoso'],

            // Caldas
            ['department' => 'Caldas', 'city' => 'Manizales'],
            ['department' => 'Caldas', 'city' => 'Villamaría'],
            ['department' => 'Caldas', 'city' => 'La Dorada'],

            // Caquetá
            ['department' => 'Caquetá', 'city' => 'Florencia'],
            ['department' => 'Caquetá', 'city' => 'San Vicente del Caguán'],

            // Casanare
            ['department' => 'Casanare', 'city' => 'Yopal'],
            ['department' => 'Casanare', 'city' => 'Aguazul'],

            // Cauca
            ['department' => 'Cauca', 'city' => 'Popayán'],
            ['department' => 'Cauca', 'city' => 'Santander de Quilichao'],

            // Cesar
            ['department' => 'Cesar', 'city' => 'Valledupar'],
            ['department' => 'Cesar', 'city' => 'La Paz'],

            // Chocó
            ['department' => 'Chocó', 'city' => 'Quibdó'],
            ['department' => 'Chocó', 'city' => 'Istmina'],

            // Córdoba
            ['department' => 'Córdoba', 'city' => 'Montería'],
            ['department' => 'Córdoba', 'city' => 'Lorica'],

            // Cundinamarca
            ['department' => 'Cundinamarca', 'city' => 'Bogotá'],
            ['department' => 'Cundinamarca', 'city' => 'Soacha'],
            ['department' => 'Cundinamarca', 'city' => 'Chía'],

            // Guainía
            ['department' => 'Guainía', 'city' => 'Inírida'],

            // Guaviare
            ['department' => 'Guaviare', 'city' => 'San José del Guaviare'],

            // Guajira
            ['department' => 'Guajira', 'city' => 'Riohacha'],
            ['department' => 'Guajira', 'city' => 'Maicao'],

            // Huila
            ['department' => 'Huila', 'city' => 'Neiva'],
            ['department' => 'Huila', 'city' => 'Pitalito'],

            // Magdalena
            ['department' => 'Magdalena', 'city' => 'Santa Marta'],
            ['department' => 'Magdalena', 'city' => 'Ciénaga'],

            // Meta
            ['department' => 'Meta', 'city' => 'Villavicencio'],
            ['department' => 'Meta', 'city' => 'Granada'],

            // Nariño
            ['department' => 'Nariño', 'city' => 'Pasto'],
            ['department' => 'Nariño', 'city' => 'Tumaco'],

            // Norte de Santander
            ['department' => 'Norte de Santander', 'city' => 'Cúcuta'],
            ['department' => 'Norte de Santander', 'city' => 'Pamplona'],

            // Putumayo
            ['department' => 'Putumayo', 'city' => 'Mocoa'],

            // Quindío
            ['department' => 'Quindío', 'city' => 'Armenia'],
            ['department' => 'Quindío', 'city' => 'Calarcá'],

            // Risaralda
            ['department' => 'Risaralda', 'city' => 'Pereira'],
            ['department' => 'Risaralda', 'city' => 'Dosquebradas'],

            // San Andrés y Providencia
            ['department' => 'San Andrés y Providencia', 'city' => 'San Andrés'],
            ['department' => 'San Andrés y Providencia', 'city' => 'Providencia'],

            // Santander
            ['department' => 'Santander', 'city' => 'Bucaramanga'],
            ['department' => 'Santander', 'city' => 'San Gil'],
            ['department' => 'Santander', 'city' => 'Barrancabermeja'],
            ['department' => 'Santander', 'city' => 'Puerto Wilches'],
            ['department' => 'Santander', 'city' => 'La Fortuna'],
            ['department' => 'Santander', 'city' => 'El Llanito'],
            ['department' => 'Santander', 'city' => 'El Centro'],

            // Sucre
            ['department' => 'Sucre', 'city' => 'Sincelejo'],
            ['department' => 'Sucre', 'city' => 'Corozal'],

            // Tolima
            ['department' => 'Tolima', 'city' => 'Ibagué'],
            ['department' => 'Tolima', 'city' => 'Espinal'],

            // Valle del Cauca
            ['department' => 'Valle del Cauca', 'city' => 'Cali'],
            ['department' => 'Valle del Cauca', 'city' => 'Palmira'],

            // Vaupés
            ['department' => 'Vaupés', 'city' => 'Mitú'],

            // Vichada
            ['department' => 'Vichada', 'city' => 'Puerto Carreño']
        ];

        // Insertar departamentos y ciudades
        foreach ($departmentsAndCities as $entry) {
            DepartmentAndCity::create($entry);
        }
    }
}
