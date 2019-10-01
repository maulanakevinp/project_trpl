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
            'title' => 'Users Management',
            'url' => '/users',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Role Management',
            'url' => '/role',
            'icon' => 'fas fa-fw fa-user-tie',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 1,
            'title' => 'Letters Management',
            'url' => '/letters',
            'icon' => 'fas fa-fw fa-envelope',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Gender Chart',
            'url' => '/gender-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Age Chart',
            'url' => '/age-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Religion Chart',
            'url' => '/religion-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Job Chart',
            'url' => '/job-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 2,
            'title' => 'Married Status Chart',
            'url' => '/marital-chart',
            'icon' => 'fas fa-fw fa-chart-bar',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 3,
            'title' => 'Submitting a Letter',
            'url' => '/letters/show',
            'icon' => 'fas fa-fw fa-envelope',
            'is_active' => 0
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'My Profile',
            'url' => '/my-profile',
            'icon' => 'fas fa-fw fa-user',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Edit Profile',
            'url' => '/edit-profile',
            'icon' => 'fas fa-fw fa-user-edit',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 4,
            'title' => 'Change Password',
            'url' => '/change-password',
            'icon' => 'fas fa-fw fa-key',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 5,
            'title' => 'Menu Management',
            'url' => '/menu',
            'icon' => 'fas fa-fw fa-folder',
            'is_active' => 1
        ]);

        DB::table('user_submenu')->insert([
            'menu_id' => 5,
            'title' => 'Submenu Management',
            'url' => '/submenu',
            'icon' => 'fas fa-fw fa-folder-open',
            'is_active' => 1
        ]);
    }
}
