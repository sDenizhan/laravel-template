<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatments = [
            'Tüp Mide',
            'Mini Bypass',
            'Gastric Bypass',
            'Gastrik Balon',
            'Revizyon Bariatrik Cerrahi',
            'Saç Ekimi',
            'Göz Ameliyatı',
            'Estetik, Plastik Cerrahi',
            'Ortopedi ve Travmatoloji',
            'Kilo Verme Ameliyatı',
            'Kalp Damar Cerrahisi',
            'Diğer / Kozmetik Diş Tedavileri',
        ];

        foreach ($treatments as $treatment) {
            \App\Models\Treatments::create([
                'name' => $treatment
            ]);
        }
    }
}
