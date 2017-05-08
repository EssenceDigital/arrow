<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Returns the associated view
    public function index(){
        return view('app.dashboard');
    }

    // Returns the associated view
    public function profile(){
        return view('app.user-profile');
    }
}
