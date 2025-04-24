<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $superadminRole = Role::create([
            'name' => 'super admin'
        ]);

        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $customerRole = Role::create([
            'name' => 'customer'
        ]);

        $user = User::create([
            'name' => 'Naufal Najmi Kardiansyah',
            'email' => 'teamholirang@gmail.com',
            'password' => '123123123',
        ]);

        $user->assignRole($superadminRole);
    }
}
