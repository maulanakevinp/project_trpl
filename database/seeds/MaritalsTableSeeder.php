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
            'marital' => 'Married'
        ]);

        DB::table('maritals')->insert([
            'marital' => 'Single'
        ]);

        DB::table('maritals')->insert([
            'marital' => 'Widow'
        ]);

        DB::table('maritals')->insert([
            'marital' => 'Widower'
        ]);
    }
}
