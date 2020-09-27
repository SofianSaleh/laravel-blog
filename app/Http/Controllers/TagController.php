<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function createTag(Request $request)
    {
        // Validation to the request 
        $this->validate($request, [
            'tagName' => 'required'
        ]);

        return  Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getAll()
    {
        return Tag::orderBy('id', 'desc')->get();
    }

    // To edit tags

    public function editTag(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'tagName' => 'required'
        ]);
        $updated = Tag::where('id', $request->id)->update([
            'tagName' => $request->tagName
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
}
