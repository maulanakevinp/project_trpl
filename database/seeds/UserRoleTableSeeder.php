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
            'role' => 'Super Admin'
        ]);

        DB::table('user_role')->insert([
            'role' => 'Kepala Desa'
        ]);

        DB::table('user_role')->insert([
            'role' => 'Administrasi'
        ]);

        DB::table('user_role')->insert([
            'role' => 'Penduduk'
        ]);
    }
}
