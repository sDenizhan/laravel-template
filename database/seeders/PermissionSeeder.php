<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            //inquiry
            'create-inquiry',
            'edit-inquiry',
            'delete-inquiry',
            'view-inquiry',
            //doctor
            'create-doctor',
            'edit-doctor',
            'delete-doctor',
            'view-doctor',
            //hospital
            'create-hospital',
            'edit-hospital',
            'delete-hospital',
            'view-hospital',
            //for doctor
            'doctor-can-view-inquiry',
         ];

          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}
