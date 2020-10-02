<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => "required|image:mimes:jpeg,jpg,png"
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function removeImg(Request $request)
    {
        $this->validate($request, [
            'name' => "required"
        ]);
        remove(public_path('uploads'), name);
        return $picName;
    }
}
