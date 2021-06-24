@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="{{route('role.create')}}" role="button">Add</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Display name</th>
                    <th scope="col">Actions</th>

                </tr>
                </thead>
                <tbody>
                @foreach($listRole as $Role)
                    <tr>
                        <th scope="row">{{$loop->index +1}}</th>
                        <td>{{$Role->name}}</td>
                        <td>{{$Role->email}}</td>
                        <td>
                            <a class="btn btn-primary" href="{{route('role.edit',['id'=>$Role->id])}}" role="button">Edit</a>
                            <a class="btn btn-danger" href="{{route('role.delete',['id'=>$Role->id])}}" role="button">Delete</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
