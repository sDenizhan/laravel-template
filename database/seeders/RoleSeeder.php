<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $coordinator = Role::create(['name' => 'Coordinator']);
        $doctor = Role::create(['name' => 'Doctor']);
        $anaesthetist = Role::create(['name' => 'Anaesthetist']);
        $patient = Role::create(['name' => 'Patient']);


        $coordinator->givePermissionTo([
            'view-inquiry',
            'create-inquiry',
            'view-active-inquiry',
        ]);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
        ]);

        $doctor->givePermissionTo([
            'doctor-can-view-inquiry',
            'doctor-can-add-notes',
        ]);

        $anaesthetist->givePermissionTo([
            'doctor-can-view-inquiry',
            'doctor-can-add-notes',
            'view-anaesthetist-inquiries',
        ]);

    }
}
