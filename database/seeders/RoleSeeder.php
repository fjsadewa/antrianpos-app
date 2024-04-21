<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::updateOrCreate(
            ['name'=> 'admin',],
            ['name'=> 'admin']
        );
        $role_employee = Role::updateOrCreate(
            ['name'=> 'employee',],
            ['name'=> 'employee']
        );

        $admin_permission = Permission::updateOrCreate(
            [
                'name' => 'view_admin',
            ],
            ['name' => 'view_admin']
        );

        $employee_permission = Permission::updateOrCreate(
            [
                'name' => 'view_employee',
            ],
            ['name' => 'view_employee']
        );

        
        $role_admin->givePermissionTo($admin_permission);
        $role_employee->givePermissionTo($employee_permission);

        $admin = User::where('name', 'admin')->first();
        $admin->assignRole(['admin']);

        $employee = User::where('name', 'user')->first();
        $employee->assignRole(['employee']);
        
    }
}
