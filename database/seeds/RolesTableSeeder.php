<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role $role */
        $role = Role::create([
            'name' => 'admin'
        ]);
        $role->givePermissionTo(Permission::all());

        Role::create([
            'name' => 'B2C Customer'
        ]);

        Role::create([
            'name' => 'B2B Customer'
        ]);
     
        Role::create([
            'name' => 'Sub Admin'
        ]);
    }
}
