<?php

namespace App\Http\Controllers;
use App\Models\category;

use Illuminate\Http\Request;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index')->with('categories',category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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

            'name'=>'required|unique:categories'
        ]);
        category::create([
            'name'=>$request->name
        ]);
        session()->flash('success','Category Create Successfully');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(category $Category)
    {
        return view('categories.create')->with('category',$Category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,category $Category)
    {
        
        $this->validate($request,[

            'name'=>'required|unique:categories'
        ]);
        // Two way to update in laravel
        $Category->update([
            'name' => $request->name,
        ]);

        // $Category->name = $request->name;
        // $Category->save();
        session()->flash('success','Category Update Successfully');
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        if($categories->posts->count() > 0)
        {
        session()->flash('error','Category cannot to be delete because it has some post');
        return redirect()->back();
        }

        $category->delete();
        session()->flash('success','Category Delete Successfully');
        return redirect(route('categories.index'));


    }
}
