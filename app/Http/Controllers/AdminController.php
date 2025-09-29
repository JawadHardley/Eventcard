<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('admin.dashboard', [
            'user' => $request->user(),
        ]);
    }

    public function transactions(Request $request)
    {
        return view('admin.transactions', [
            'user' => $request->user(),
        ]);
    }
}
