<?php

use Illuminate\Database\Seeder;

class SalariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salaries')->insert([
            'user_id'       => 4,
            'salary'        => '1000000',
            'reason'        => 'Kami mengajukan surat keterangan penghasilan untuk memenuhi syarat pendaftaran masuk PTN',
            'verify1'       => 1,
            'verify2'       => 1,
            'created_at'    => '2019-10-11 10:37:13',
            'updated_at'    => '2019-10-11 10:37:13',
        ]);
    }
}
