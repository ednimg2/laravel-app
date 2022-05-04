@extends('layout')

@section('content')
<!--
1. password laukas
2. new password laukas
-->
    <h1>Change password</h1>

    <form action="{{ route('user.password_change_submit') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="password1" class="form-label">Old password</label>

            @error('password')
                <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="password" type="password" class="form-control" id="password1">
        </div>
        <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>

            @error('new_password')
                <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="new_password" type="password" class="form-control" id="newPassword">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
