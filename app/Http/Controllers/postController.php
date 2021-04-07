<?php

namespace App\Http\Controllers;
use App\Models\post;
use App\Models\category;
use App\Models\Tag;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;




class postController extends Controller
{

    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create','store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts',post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', category::all())->with('tags', Tag::all());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[

            'title'=>'required|unique:posts',
            'description'=>'required',
            'image'=>'required|image',
            'content'=>'required',
            'category' => 'required'
        ]);
        $image = $request->image->store('posts');

        $post = post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image,
            'published_at'=>$request->published_at,
            'category_id'=>$request->category,
            'user_id'=>auth()->user()->id

        ]);
        if($request->tags)
        {
            $post->tags()->attach($request->tags);
        } 
        session()->flash('success','Post Create Successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        return view('posts.create')->with('post',$post)->with('categories', category::all())->with('tags', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,post  $post)
    {
        $this->validate($request,[

            'title'=>'required',
            'description'=>'required',
            'content'=>'required',
            'category' => 'required'
        ]);

        $data = $request->only(['title','content','description','published_at']);
        // check for new image
        if($request->hasFile('image')){
            // upload new image
            $image = $request->image->store('posts');
            // delete old one
            Storage::delete($post->image);

            $data['image'] = $image;
        }
        if($request->tags)
        {
            $post->tags()->sync($request->tags);
        } 

        $post->update($data);
        session()->flash('success','Post Update Successfully');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post =post::withTrashed()->where('id',$id)->firstOrFail();
        if($post->trashed())
        {
            Storage::delete($post->image);
            $post->forceDelete();
        }
        else
        {
            $post->delete();
        }
        session()->flash('success','Post Delete Successfully');

        return redirect(route('posts.index'));
    }



     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed=post::onlyTrashed()->get();
        return view('posts.index')->with('posts',$trashed);
    }

    public function restore($id)
    {
        $post =post::withTrashed()->where('id',$id)->firstOrFail();
        $post->restore();
        session()->flash('success','Post Restore Successfully');
        return redirect()->back();
    }

}
