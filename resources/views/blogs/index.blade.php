@extends('components.column-1')

@section('body')
    <div class="row">
        <div class="col">
            <h1>Blogs</h1>
            <a href="{{ route('blogs.create') }}" class="btn btn-primary" title="New Blog">New blog</a>
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="New Blog">Active</a>
            <a href="{{ url('blogs/inactive') }}" class="btn btn-primary" title="New Blog">Inactive</a>
            <a href="{{ url('blogs/wishlist') }}" class="btn btn-primary" title="New Blog">Wshlist</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

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
                <td></td>
                <td>{{ Str::limit($blog->description, 100) }}</td>
                <td>{{ $blog->is_active }}</td>
                <td>
                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ url('blogs/add-to-wishlist', $blog->id) }}" class="btn btn-success">Add to wishlist</a>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{--}}
    {{ $blogs->links() }}
    {{--}}
@endsection
