@extends('layout')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Blog show</h1>
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="Back">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h3>{{ $blog->title }}</h3>
            <span>{{ $blog->author }}</span>
            <p>{{ $blog->description }}</p>
        </div>
    </div>
@endsection
