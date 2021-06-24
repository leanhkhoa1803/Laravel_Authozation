@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-md-8" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="Enter email">
                </div>

                <select class="form-control" style="margin-bottom:20px" name="roles[]" multiple="multiple">
                    @foreach($listRole as $role)
                        <option value="{{$role->id}}" {{$listRoleOfUser->contains($role->id) ? 'selected' : ''}}>{{$role->display_name}}</option>

                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
