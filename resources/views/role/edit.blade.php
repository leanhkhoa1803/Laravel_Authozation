@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-md-8" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$roles->name}}" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="email">Display name</label>
                    <input type="text" class="form-control" name="display_name" value="{{$roles->display_name}}" placeholder="Enter email">
                </div>

                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="permissions[]"
                               {{$permissionOfRole->contains($permission->id) ? 'checked' : ''}} value="{{$permission->id}}">
                        <label class="form-check-label" for="exampleCheck1">{{$permission->display_name}}</label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
