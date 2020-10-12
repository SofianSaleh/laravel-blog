<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VueController extends Controller
{
    //
    public function index(Request $request)
    {
        // Check if the user is admin
        if (!Auth::check()) {
            return redirect('/login');
        };
        return $request->path();
        // return view('welcome');
    }
}
