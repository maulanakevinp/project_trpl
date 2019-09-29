<?php

use Illuminate\Database\Seeder;

class ReligionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('religions')->insert([
            'religion' => 'Islam'
        ]);

        DB::table('religions')->insert([
            'religion' => 'Christian'
        ]);

        DB::table('religions')->insert([
            'religion' => 'Catholic'
        ]);

        DB::table('religions')->insert([
            'religion' => 'Hindu'
        ]);

        DB::table('religions')->insert([
            'religion' => 'Buddha'
        ]);
    }
}
