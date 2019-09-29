<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PopulationGraphController extends Controller
{
    public function gender()
    {
        $title = "Gender Chart";
        return view('chart.gender', compact('title'));
    }
    public function age()
    {
        $title = "Age Chart";
        return view('chart.age', compact('title'));
    }
    public function religion()
    {
        $title = "Religion Chart";
        return view('chart.religion', compact('title'));
    }
    public function job()
    {
        $title = "Job Chart";
        return view('chart.job', compact('title'));
    }
    public function marital()
    {
        $title = "Married Status Chart";
        return view('chart.marital', compact('title'));
    }
}
