<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Suleyman Denizhan',
            'email' => 'suleyman.denizhan@gmail.com',
            'password' => Hash::make('suleyman1234')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Sinan Gülbaş',
            'email' => 'ismailsinan@gmail.com',
            'password' => Hash::make('ismail1234')
        ]);
        $admin->assignRole('Admin');

        $doctors = [
            [
                'name' => 'Ahmet Körmutlu',
                'email' => 'ahmet@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Ali Tardu',
                'email' => 'ali@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Dr. Soner Karaali',
                'email' => 'soner@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Emin Atlı',
                'email' => 'emin@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Emre Can Kocman',
                'email' => 'emre@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Esma Özdemir',
                'email' => 'esma@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Fatih Uzun',
                'email' => 'fatih@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Funda Aköz',
                'email' => 'funda@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Hakan Fatih Merev',
                'email' => 'hakanfatihmrv@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Kağan Katar',
                'email' => 'kagan@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Koray Temiz',
                'email' => 'koraytemiz@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Mert Baltacı',
                'email' => 'mert@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Mustafa Tekir',
                'email' => 'mustafatekir@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Nebil Selimoğlu',
                'email' => 'nebil@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Okan Övünç',
                'email' => 'okanovunc@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Ömer Parıldar',
                'email' => 'omerparildar@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Rachel Wise',
                'email' => 'rachel@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Serhat Şen',
                'email' => 'serhat@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Sevil Kara',
                'email' => 'sevil@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Soner Karaali',
                'email' => 'sonerkaraali@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Uğur Azizoğlu',
                'email' => 'ugurazizoglu@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Vijdan Aslanoglu',
                'email' => 'vijdan@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Yalçın Leymunçiçeği',
                'email' => 'yalcin@bookingsurgery.com',
                'password' => Str::random(10)
            ],
        ];

        // Creating Doctor User
        foreach ($doctors as $doctor) {
            $doctor = User::create($doctor);
            $doctor->assignRole('Doctor');
        }

        // Creating Anaesthetist User
        $anaesthetists = [
            [
                'name' => 'Yasin Esen',
                'email' => 'yasinesen@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Zülfikar Şimşek',
                'email' => 'zulfikar@bookingsurgery.com',
                'password' => Str::random(10)
            ],
        ];

        foreach ($anaesthetists as $anaesthetist) {
            $anaesthetist = User::create($anaesthetist);
            $anaesthetist->assignRole('Anaesthetist');
        }

        // Creating Coordinator
        $coordinators = [
            [
                'name' => 'April O’neal',
                'email' => 'april@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Ashley Cooper',
                'email' => 'ashley@bookingsurgery.com',
                'password' => Str::random(10)
            ],
            [
                'name' => 'Chloe White',
                'email' => 'chloe@bookingsurgery.com',
                'password' => Str::random(10)
            ],  
        ];

        foreach ($coordinators as $coordinator) {
            $coordinator = User::create($coordinator);
            $coordinator->assignRole('Coordinator');
        }
    }
}
