<?php

namespace App\Http\Controllers;

use App\Gender;
use App\Marital;
use App\Religion;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PopulationGraphController extends Controller
{
    public function gender()
    {
        $title = "Jenis Kelamin";
        $genders = Gender::all();
        $data_laki = User::whereGenderId(1)->count();
        $data_perempuan = User::whereGenderId(2)->count();
        return view('chart.gender', compact('title', 'data_laki', 'data_perempuan'));
    }
    public function age()
    {
        $title = "Usia";
        $users = User::all();
        $categories = ['0 - 4 tahun','5 - 9 tahun','10 - 14 tahun','15 - 19 tahun','20 - 24 tahun','25 - 29 tahun','30 - 34 tahun','35 - 39 tahun','40 - 44 tahun','45 - 49 tahun','50 - 54 tahun','55 - 59 tahun','>= 60 tahun'];
        $age0 = 0; $age1 = 0; $age2 = 0; $age3 = 0; $age4 = 0; $age5 = 0; $age6 = 0; $age7 = 0; $age8 = 0; $age9 = 0; $age10 = 0; $age11 = 0; $age12 = 0;

        foreach ($users as $user) {
            $age = (int) Carbon::parse($user->birth_date)->diff(Carbon::now())->format('%y');
            if ($age >= 0 && $age <= 4) {
                $age0 += 1;
            } elseif ($age >= 5 && $age <= 9) {
                $age1 += 1;
            } elseif ($age >= 10 && $age <= 14) {
                $age2 += 1;
            } elseif ($age >= 15 && $age <= 19) {
                $age3 += 1;
            } elseif ($age >= 20 && $age <= 24) {
                $age4 += 1;
            } elseif ($age >= 25 && $age <= 29) {
                $age5 += 1;
            } elseif ($age >= 30 && $age <= 34) {
                $age6 += 1;
            } elseif ($age >= 35 && $age <= 39) {
                $age7 += 1;
            } elseif ($age >= 40 && $age <= 44) {
                $age8 += 1;
            } elseif ($age >= 45 && $age <= 49) {
                $age9 += 1;
            } elseif ($age >= 50 && $age <= 54) {
                $age10 += 1;
            } elseif ($age >= 55 && $age <= 59) {
                $age11 += 1;
            } elseif ($age >= 60) {
                $age12 += 1;
            }
        }

        $data = [
            $age0, $age1, $age2, $age3, $age4, $age5, $age6, $age7, $age8, $age9, $age10, $age11, $age12
        ];

        return view('chart.age', compact('title', 'categories', 'data'));
    }
    public function religion()
    {
        $title = "Agama";
        $religions = Religion::all();
        $categories = [];
        $data = [];

        foreach ($religions as $religion) {
            $categories[] = $religion->religion;
            $data[] = User::whereReligionId($religion->id)->count();
        }

        return view('chart.religion', compact('title', 'categories', 'data'));
    }
    public function marital()
    {
        $title = "Status Pernikahan";
        $maritals = Marital::all();
        $categories = [];
        $data = [];

        foreach ($maritals as $marital) {
            $categories[] = $marital->marital; 
            $data[] = User::whereMaritalId($marital->id)->count();
        }
        
        return view('chart.marital', compact('title','categories','data'));
    }
}
