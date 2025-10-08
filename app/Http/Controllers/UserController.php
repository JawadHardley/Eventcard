<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('dashboard', [
            'user' => $request->user(),
        ]);
    }

    public function cameralog(Request $request)
    {
        return view('cameralog', [
            'user' => $request->user(),
        ]);
    }
}
