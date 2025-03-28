<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Language;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,
            TreatmentSeeder::class,
            HospitalSeeder::class,
            DoctorSeeder::class,
            LanguageSeeder::class,
            CountrySeeder::class,
            InqurySeeder::class
        ]);
    }
}
