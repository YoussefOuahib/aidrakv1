<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctor = Role::create(['name' => 'Doctor']);
        $doctor->permissions()->attach(Permission::pluck('id'));

        $receptionist = Role::create(['name' => 'Receptionist']);
        $receptionist->permissions()->attach(
            Permission::whereNotIn('name', ['patients.delete', 'appointments.store', 'appointments.delete', 'appointments.update', 'conditions.manage', 'invoices.manage', 'settings.manage'])->pluck('id')
        );
    }
}
