<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Roles'
            ],
            [
                'name' => 'Sub-admin'
            ],
            [
                'name' => 'Users'
            ],
            [
                'name' => 'Products'
            ],
        
        ])->each(function ($permission) {
            Permission::create([
                'name' => $permission['name'] . '-view'
            ]);
            Permission::create([
                'name' => $permission['name'] . '-create'
            ]);
            Permission::create([
                'name' => $permission['name'] . '-edit'
            ]);
            Permission::create([
                'name' => $permission['name'] . '-delete'
            ]);
        });
    }
}
