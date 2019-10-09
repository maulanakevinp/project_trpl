<?php

use Illuminate\Database\Seeder;

class MaritalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maritals')->insert([
            'marital' => 'Menikah'
        ]);

        DB::table('maritals')->insert([
            'marital' => 'Lajang'
        ]);

        DB::table('maritals')->insert([
            'marital' => 'Duda'
        ]);

        DB::table('maritals')->insert([
            'marital' => 'Janda'
        ]);
    }
}
