<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function createUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'required',
            'password' => 'required',
            'userType' => 'required',
        ]);
    }
}
