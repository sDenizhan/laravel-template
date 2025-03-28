<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hospitals = [
            'Avrasya Hospital',
            'Biruni Hospital',
            'Dentx Hospital',
            'Era Hospital',
            'Medistanbul',
            'Optimed',
            'Yasam Hospital'
        ];

        foreach ($hospitals as $hospital) {
            \App\Models\Hospital::create([
                'name' => $hospital
            ]);
        }
    }
}