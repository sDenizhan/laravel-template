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
            'Acıbadem Hospital',
            'Memorial Hospital',
            'Medical Park Hospital',
            'Florence Nightingale Hospital',
            'Medicana Hospital',
            'Anadolu Hospital',
            'American Hospital'
        ];

        foreach ($hospitals as $hospital) {
            \App\Models\Hospital::create([
                'name' => $hospital
            ]);
        }
    }
}
