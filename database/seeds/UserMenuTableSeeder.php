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
            'menu' => 'Grafik Penduduk',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Member',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Profil',
        ]);

        DB::table('user_menu')->insert([
            'menu' => 'Menu',
        ]);
    }
}
