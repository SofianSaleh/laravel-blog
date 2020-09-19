<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function createTag(){
        return response()->json([
            'msg' => 'hey there'
        ],422);
    }
}
