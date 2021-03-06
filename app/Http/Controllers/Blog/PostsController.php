<?php

namespace App\Http\Controllers\Blog;
use App\Models\post;
use App\Models\category;
use App\Models\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function show(post $post)
    {
        return view('blog.show')->with('post', $post);
    }
    public function category(category $category)
    {
        $search = request()->query('search');
        if($search)
        {
            $posts =$category->posts()->where('title','LIKE',"%{$search}%")->simplePaginate(3);
        }
        else
        {
            $posts =$category->posts()->simplePaginate(3);
        }

        return view('blog.category')
        ->with('category',$category)
        ->with('posts',$posts)
        ->with('categories',category::all())
        ->with('tags',Tag::all());
    }
    public function tag(Tag $tag)
    {
        return view('blog.tag')
        ->with('tag',$tag)
        ->with('categories',category::all())
        ->with('tags',Tag::all())
        ->with('posts',$tag->posts()->simplePaginate(3));
    }
}
