<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'name' => 'Dr. Ahmet Yılmaz',
                'email' => 'ahmetyilmaz@test.com',
                'password' => Hash::make('ahmet1234')
            ],
            [
                'name' => 'Dr. Mehmet Yılmaz',
                'email' => 'mehmetyilmaz@test.com',
                'password' => Hash::make('mehmet1234')
            ],
            [
                'name' => 'Dr. Ayşe Yılmaz',
                'email' => 'ayseyilmaz@gmail.com',
                'password' => Hash::make('ayse1234')
            ]
        ];

        // Creating Doctor User
        foreach ($doctors as $doctor) {
            $doctor = User::create($doctor);
            $doctor->assignRole('Doctor');
        }

        // Creating Anaesthetist User
        $anaesthetists = [
            [
                'name' => 'Dr. Şevket Yılmaz',
                'email' => 'sevket@yilmaz.com.tr',
                'password' => Hash::make('sevket1234')
            ],
            [
                'name' => 'Dr. Hüseyin Yılmaz',
                'email' => 'huseyin@yilmaz.com.tr',
                'password' => Hash::make('huseyin1234')
            ],
            [
                'name' => 'Dr. Can Yılmaz',
                'email' => 'can@yilmaz.com.tr',
                'password' => Hash::make('mehmet1234')
            ]
        ];

        foreach ($anaesthetists as $anaesthetist) {
            $anaesthetist = User::create($anaesthetist);
            $anaesthetist->assignRole('Anaesthetist');
        }
    }
}
