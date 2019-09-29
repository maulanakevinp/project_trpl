<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserRoleTableSeeder::class,
            UserMenuTableSeeder::class,
            UserAccessMenuTableSeeder::class,
            UserSubmenuTableSeeder::class,
            GendersTableSeeder::class,
            ReligionsTableSeeder::class,
            MaritalsTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
