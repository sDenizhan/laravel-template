<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'English', 'code' => 'en', 'sort' => 1],
            ['name' => 'Turkish', 'code' => 'tr', 'sort' => 2],
            ['name' => 'France', 'code' => 'fr', 'sort' => 3]
        ];

        foreach ($data as $lang) {
            Language::create($lang);
        }
    }
}
