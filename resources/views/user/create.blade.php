@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Create User</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('users.store')}}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">
                    Name
                </label>
                <input type="text" name="name" id="name" class="form-control">

            </div>
            <div class="form-group">
                <label for="email">
                    Email
                </label>
                <input type="text" name="email" id="email" class="form-control">

            </div>
            <div class="form-group">
                <label for="mobile">
                    Mobile
                </label>
                <input type="text" name="mobile" id="mobile" class="form-control">

            </div>

            <div class="form-group">
                <label for="password">
                    Password
                </label>
                <input type="password" name="password" id="password" class="form-control">

            </div>
            <div class="form-group">
                <label for="password_confirmation">
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">

            </div>

            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{route('users.index')}}" class="btn btn-dark">Back</a>
        </form>

    </div>
@endsection
