<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function createTag(Request $request){
        // Validation to the request 
        $this->validate($request, [
            'tagName' => 'required'
        ]);
        
        return  Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function getAll(){
        return Tag::orderBy('id','desc')->get();
    }
}
