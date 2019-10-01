<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'Namanya IT',
            'nik' => '0099887766554555',
            'image' => 'default.jpg',
            'gender_id' => 1,
            'religion_id' => 1,
            'marital_id' => 2,
            'address' => 'Jln. jalan di pagi hari No.01 RT/RW 001/001',
            'birth_place' => 'Jember',
            'birth_date' => '2000-01-01',
            'job' => 'Developer',
            'email' => 'dev@gmail.com',
            'email_verified_at' => '2019-09-28 10:00:00',
            'password' => Hash::make('123123'),
            'created_at' => '2019-09-28 10:00:00',
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'Donald Trump',
            'nik' => '3209291201560001',
            'image' => 'icons8_donald_trump_100px.png',
            'gender_id' => 1,
            'religion_id' => 1,
            'marital_id' => 2,
            'address' => 'Jln. Nenek Moyang lo No.01 RT/RW 001/001',
            'birth_place' => 'Jember',
            'birth_date' => '1999-05-08',
            'job' => 'Student',
            'email' => 'kepala@gmail.com',
            'email_verified_at' => '2019-09-28 10:00:00',
            'password' => Hash::make('123123'),
            'created_at' => '2019-09-28 10:00:00',
        ]);

        DB::table('users')->insert([
            'role_id' => 3,
            'name' => 'Namanya Admin Desa',
            'nik' => '4321123454322345',
            'image' => 'admin.png',
            'gender_id' => 2,
            'religion_id' => 1,
            'marital_id' => 2,
            'address' => 'Jln. Nenek Moyang lo No.01 RT/RW 001/001',
            'birth_place' => 'Jember',
            'birth_date' => '1999-05-08',
            'job' => 'Student',
            'email' => 'admin@gmail.com',
            'email_verified_at' => '2019-09-28 10:00:00',
            'password' => Hash::make('123123'),
            'created_at' => '2019-09-28 10:00:00',
        ]);

        DB::table('users')->insert([
            'role_id' => 4,
            'name' => 'Maulana Kevin Pradana',
            'nik' => '3509220805990001',
            'image' => '1569540948_kevin(1).jpg',
            'gender_id' => 1,
            'religion_id' => 1,
            'marital_id' => 2,
            'address' => 'Jln. Nenek Moyang lo No.01 RT/RW 001/001',
            'birth_place' => 'Jember',
            'birth_date' => '1999-05-08',
            'job' => 'Student',
            'email' => 'maulanakevinp@gmail.com',
            'email_verified_at' => '2019-09-28 10:00:00',
            'password' => Hash::make('123123'),
            'created_at' => '2019-09-28 10:00:00',
        ]);
    }
}
