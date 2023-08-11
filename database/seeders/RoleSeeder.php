<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Roles = ['customer', 'worker', 'supervisor', 'production_manager', 'owner', 'super_admin'];
        $n = 1;

        foreach ($Roles as $key => $item) {
            $role = new Role();
            $role->id = $n;
            $role->role = $item;
            $role->save();

            $n++;
        }
    }
}
