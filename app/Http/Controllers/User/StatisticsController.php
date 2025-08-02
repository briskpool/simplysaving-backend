<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('user.moto-markets');
    }
    public function football()
    {
        return view('user.football-markets');
    }
    public function bundesliga()
    {
        return view('user.bundesliga-markets');
    }
    public function french_league()
    {
        return view('user.french-markets');
    }
    public function laliga()
    {
        return view('user.laliga-markets');
    }
    public function uefa()
    {
        return view('user.uefa-markets');
    }
}
