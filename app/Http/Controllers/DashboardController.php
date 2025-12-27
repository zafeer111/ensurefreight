<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        if (!Session::has('session_start_time')) {
            Session::put('session_start_time', now());
        }
        
        $sessionStartTime = Session::get('session_start_time');
        return view('customer-dashboard', compact('sessionStartTime'));
    }
}
