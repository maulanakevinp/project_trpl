<?php

use Illuminate\Database\Seeder;

class LettersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('letters')->insert([
            'number'        => 1,
            'verify1'       => 1,
            'verify2'       => 1,
            'created_at'    => '2019-10-11 10:37:13',
            'updated_at'    => '2019-10-12 10:37:13'
        ]);
    }
}
