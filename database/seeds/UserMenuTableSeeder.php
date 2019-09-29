<?php

use Illuminate\Database\Seeder;

class UserMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_menu')->insert([
            'menu' => 'Admin',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Population Graph',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Member',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Profile',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Menu',
        ]);
    }
}
