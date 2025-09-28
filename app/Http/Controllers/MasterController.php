<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        // any logic you want to pass to the welcome page
        return view('home');
    }
}