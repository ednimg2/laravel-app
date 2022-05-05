@extends('layout')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Blogs</h1>
            <a href="{{ route('blogs.create') }}" class="btn btn-primary" title="New Blog">New blog</a>
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="New Blog">Active</a>
            <a href="{{ url('blogs/inactive') }}" class="btn btn-primary" title="New Blog">Inactive</a>
            <a href="{{ url('blogs/wishlist') }}" class="btn btn-primary" title="New Blog">Wshlist</a>
        </div>
    </div>

    <table class="table">
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Author</td>
            <td>Description</td>
            <td>Is Active</td>
            <td width="200"></td>
        </tr>
        @foreach($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td><a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a></td>
                <td>{{ $blog->author }}</td>
                <td>{{ $blog->description }}</td>
                <td>{{ $blog->is_active }}</td>
                <td>
                    <a href="{{ url('blogs/delete-wishlist', $blog->id) }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </table>

@endsection
