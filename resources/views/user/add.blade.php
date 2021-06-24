@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form class="col-md-8" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" aria-describedby="emailHelp" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password"  placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="password">Comfirm Password</label>
                    <input type="password" class="form-control" name="password"  placeholder="Confirm_Password">
                </div>
                <select class="form-control" style="margin-bottom:20px" name="roles[]" multiple="multiple">
                    @foreach($listRole as $role)
                    <option value="{{$role->id}}">{{$role->display_name}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
