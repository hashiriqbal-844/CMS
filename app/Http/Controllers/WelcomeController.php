<?php

namespace App\Http\Controllers;
use App\Models\post;
use App\Models\category;
use App\Models\Tag;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $search = request()->query('search');
        if($search)
        {
            $posts =post::where('title','LIKE',"%{$search}%")->simplePaginate(3);
        }
        else
        {
            $posts =post::simplePaginate(3);
        }
        return view('welcome')
        ->with('categories' ,category::all())
        ->with('tags' ,Tag::all())
        ->with('posts' ,$posts);
    }
}
