@extends('layout')

@section('content')
    <h1>Reset password</h1>
    <form action="{{ route('password_reminder.submit', ['token' => $token, 'email' => $email]) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>

            @error('password')
            <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="password" type="text" class="form-control" id="password">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
