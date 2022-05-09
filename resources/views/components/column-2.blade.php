@extends('layout')

@section('content')
<div class="row">
    <div class="col-2">
        @include('components.left-menu')
    </div>
    <div class="col-10">
        @yield('body')
    </div>
</div>
@endsection
