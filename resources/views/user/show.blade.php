@extends('layout')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col">
                <img src="https://www.business2community.com/wp-content/uploads/2017/08/blank-profile-picture-973460_640.png">
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        Name:
                    </div>
                    <div class="col">
                        {{ $user->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        Email:
                    </div>
                    <div class="col">
                        {{ $user->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{route('user.password_change')}}">
        Change password
    </a>
    ||
    <a href="{{route('logout')}}">
        Logout
    </a>

@endsection
