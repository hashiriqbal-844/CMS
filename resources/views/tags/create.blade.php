@extends('layouts.app')
@section('content')
<div class="card card-default">
<div class="card-header">
{{isset($tag) ? 'Edit tag' : 'Create tag'}}
</div>
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
<form action="{{isset($tag) ? route('tags.update', $tag->id) : route('tags.store')}}" method="POST">
@csrf
@if(isset($tag))
@method('PUT')
@endif
<div class="form-group">
<label for="name">Name</label>
<input type="text" class="form-control" id="name" name="name" value="{{isset($tag) ? $tag->name : ''}}">
</div>
<div class="form-group">
<button class="btn btn-success">{{isset($tag) ? 'Update tag' : 'Add tag'}}</button>
</div>
</form>
</div>
</div>

@endsection