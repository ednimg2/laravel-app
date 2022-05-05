@extends('layout')

@section('content')
    <h1>Register</h1>

    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>

            @error('email')
                <div >{{ $message }}</div>
            @enderror

            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}">

            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>

            @error('password')
                <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="password" type="password" class="form-control" id="exampleInputPassword1">
        </div>


        <div class="mb-3">
            <label for="exampleInputPassword2" class="form-label">Second password</label>

            @error('second_password')
                <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="second_password" type="password" class="form-control" id="exampleInputPassword2">
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>

            @error('name')
                <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="name" type="text" class="form-control" id="name" value="{{ old('name') }}">
        </div>

        <div class="md-3">
            <label for="birthday" class="form-label">Birthday</label>

            @error('birthday')
                <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="birthday" type="date" class="form-control" id="birthday" value="{{ old('birthday') }}">
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
@endsection
