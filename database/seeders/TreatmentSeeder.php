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
            'Liposuction',
            'Tummy Tuck',
            'Breast Augmentation',
            'Breast Lift',
            'Breast Reduction',
            'Breast Reconstruction',
            'Facelift',
            'Eyelid Surgery',
            'Brow Lift',
            'Rhinoplasty',
            'Ear Surgery',
            'Chin Surgery',
            'Cheek Augmentation'
        ];

        foreach ($treatments as $treatment) {
            \App\Models\Treatments::create([
                'name' => $treatment
            ]);
        }
    }
}
