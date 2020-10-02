<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function PHPUnit\Framework\fileExists;

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
        $fileName = $request->name;
        $this->deleteFromServer($fileName);
        return 'done';
    }

    public function deleteFromServer($fileName)
    {
        $filePath = public_path() . '/uploads/' . $fileName;

        if (fileExists($filePath)) {
            unlink($filePath);
        }
        return;
    }
}
