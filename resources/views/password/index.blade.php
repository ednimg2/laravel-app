@extends('layout')

@section('content')
    <h1>Change old password</h1>
    <form action="{{ route('password_reminder.send') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>

            @error('email')
            <div class="alert alert-warning">{{ $message }}</div>
            @enderror

            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
