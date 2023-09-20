<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
                'name' => 'admin',
                'email' => 'team.alkurn@gmail.com',
                'password' => Hash::make('123456789'),
                'email_verified_at' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s")

        ]);

        $user->assignRole('admin');

        $subAdmin = User::create([
            'name' => 'admin',
            'email' => 'sub-admin@yopmail.com',
            'password' => Hash::make('123456789'),
            'email_verified_at' => date("Y-m-d h:i:s"),
            'created_at' => date("Y-m-d h:i:s")
        ]);

        $subAdmin->assignRole('Sub Admin');

    }
}
