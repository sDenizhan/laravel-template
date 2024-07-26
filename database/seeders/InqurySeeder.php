<?php

namespace Database\Seeders;

use App\Models\Inquiry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InqurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inquiry::factory()->count(100)->create();
    }
}
