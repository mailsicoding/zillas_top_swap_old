<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Dashboard']);
        Permission::create(['name' => 'Users']);
        Permission::create(['name' => 'Roles']);
        Permission::create(['name' => 'Funds']);
        Permission::create(['name' => 'Offers']);
        Permission::create(['name' => 'Getting Match']);
        Permission::create(['name' => 'Account Setting']);
        Permission::create(['name' => 'AdminChat']);
    }
}
