<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            'role' => 'Admin'
        ]);

        DB::table('user_role')->insert([
            'role' => 'Member'
        ]);
    }
}
