<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '+923000000000',
            'password' => Hash::make('admin@123'),
            'is_phone_verified' => 1,
            'is_email_verified' => 1,
        ]);

        $role = Role::find(3);
        $user->assignRole($role->name);
        $role->givePermissionTo(['Dashboard','Users','Roles','Account Setting']);

        $role = Role::find(1);
        $role->givePermissionTo(['Dashboard','Getting Match','Offers','Account Setting']);

        $role = Role::find(2);
        $role->givePermissionTo(['Dashboard','Funds','Account Setting']);
    }
}
