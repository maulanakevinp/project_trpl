<?php

use Illuminate\Database\Seeder;

class UserSubmenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Dashboard',
            'url' => '/',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Manajemen Pengguna',
            'url' => '/users',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Manajemen Peran',
            'url' => '/role',
            'icon' => 'fas fa-fw fa-user-tie',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Manajemen Surat',
            'url' => '/letters',
            'icon' => 'fas fa-fw fa-envelope',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Grafik Jenis Kelamin',
            'url' => '/gender-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Grafik Umur',
            'url' => '/age-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Grafik agama',
            'url' => '/religion-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Grafik Pekerjaan',
            'url' => '/job-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Grafik Pernikahan',
            'url' => '/marital-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Pengajuan surat',
            'url' => '/pengajuan-surat',
            'icon' => 'fas fa-fw fa-envelope',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Profil Saya',
            'url' => '/my-profile',
            'icon' => 'fas fa-fw fa-user',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Ubah Profil',
            'url' => '/edit-profile',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Ganti Kata Sandi',
            'url' => '/change-password',
            'icon' => 'fas fa-fw fa-key',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 5,
            'title' => 'Manajemen Menu',
            'url' => '/menu',
            'icon' => 'fas fa-fw fa-folder',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 5,
            'title' => 'Manajemen Submenu',
            'url' => '/submenu',
            'icon' => 'fas fa-fw fa-folder-open',
            'is_active' => 1
        ]);
    }
}
