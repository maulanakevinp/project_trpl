<?php

use Illuminate\Database\Seeder;

class UserAccessMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_access_menu')->insert([
            'role_id' => 1,
            'menu_id' => 1
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 1,
            'menu_id' => 4
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 1,
            'menu_id' => 5
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 2,
            'menu_id' => 3
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 2,
            'menu_id' => 2
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 2,
            'menu_id' => 4
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 3,
            'menu_id' => 3
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 3,
            'menu_id' => 4
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 4,
            'menu_id' => 3
        ]);

        DB::table('user_access_menu')->insert([
            'role_id' => 4,
            'menu_id' => 4
        ]);
    }
}
