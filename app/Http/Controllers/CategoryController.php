<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function upload(Request $request)
    {
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }
}
