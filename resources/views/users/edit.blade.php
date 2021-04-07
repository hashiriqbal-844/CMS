@extends('layouts.app')

@section('content')
<div class="card">
                <div class="card-header">My Profile</div>

                <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                <ul class="list-group">
                @foreach($errors->all() as $error)
                <li class="list-group-item text-danger">
                {{$error}}
                </li>
                @endforeach
                </ul>
                </div>
                @endif
                <form action="{{route('users.edit-profile')}}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                <label for="about">About Me</label>
                <textarea name="about" id="about" cols="91" rows="5">{{$user->about}}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Update Profile</button>
                </form>
                </div>
            </div>
@endsection
