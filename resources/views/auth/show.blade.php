@extends('layout')

@section('content')
    <form action="{{ route('auth') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>

            @error('email')
                <div class="alert alert-warning">{{ $message }}</div>
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

        <div class="md-3">
            <label>Remember Me</label>
            <input type="checkbox" value="1" name="rememberMe">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
