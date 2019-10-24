<?php

namespace App\Http\Controllers;

use App\Incapable;
use App\Letter;
use App\Salary;
use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Dashboard';
        $users = User::all();
        $letters_approved = Letter::whereVerify2(1)->count();
        $letters_declined = Letter::whereVerify1(-1)->count();
        $unprocessed = Salary::whereLetterId(null)->count() + Incapable::whereLetterId(null)->count();
        return view('index', compact('title', 'users','letters_approved','letters_declined','unprocessed'));
    }
}
