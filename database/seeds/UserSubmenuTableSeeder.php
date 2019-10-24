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
            'menu_id' => 2,
            'title' => 'Jenis Kelamin',
            'url' => '/jenis-kelamin',
            'icon' => 'fas fa-fw fa-venus-mars',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Usia',
            'url' => '/usia',
            'icon' => 'fas fa-fw fa-sort-numeric-up-alt',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Agama',
            'url' => '/agama',
            'icon' => 'fas fa-fw fa-pray',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Status Pernikahan',
            'url' => '/status-pernikahan',
            'icon' => 'fas fa-fw fa-heartbeat',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Pengajuan Surat',
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
