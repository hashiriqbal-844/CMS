<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with('users', User::all());
    }
    public function makeAdmin(User $user)
    {
        $user->role = 'admin';
        $user->save();
        session()->flash('success','user make Admin Successfully');
        return redirect(route('users.index'));
    }

    public function edit()
    {
        return view('users.edit')->with('user',auth()->user());
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $this->validate($request,[

            'name'=>'required',
            'about'=>'required'
        ]);
        $user->update([
            'name' => $request->name,
            'about' => $request->about

        ]);
        session()->flash('success','user update Successfully');
        return redirect()->back();
    }
}
