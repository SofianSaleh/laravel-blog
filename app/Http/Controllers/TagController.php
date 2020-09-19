<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function createTag(Request $request){
        return  Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getAll(){
        system.out.println('hello');
        return Tag::all();
    }
}
