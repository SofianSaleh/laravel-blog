<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use function PHPUnit\Framework\fileExists;

class CategoryController extends Controller
{
    //
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'name' => "required",
            'iconImage' => "required"
        ]);

        return  Category::create([
            'name' => $request->name,
            'iconImage' => '/uploads/' . $request->iconImage
        ]);
    }

    public function getAll()
    {
        // $this->validate($request, [
        //     'name' => "required",
        //     'iconImage' => "required"
        // ]);

        return  Category::orderBy('id', 'desc')->get();
    }

    public function editCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => "required",
            'iconImage' => "required"
        ]);

        $updated = Category::where('id', $request->id)->update([
            'name' => $request->name,
            'iconImage' => $request->iconImage,
        ]);
        if ($updated) {
            return response()->json([
                'tagName' => $request->tagName,
                'id' => $request->id
            ]);
        } else {
            return response()->json([
                'error' => "Failed to update try again"
            ]);
        }
    }

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
