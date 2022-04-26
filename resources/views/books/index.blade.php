@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="pull-left">
                <h2>Books CRUD</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('books.create') }}"> Create New Book</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered my-2">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($books as $book)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->description }}</td>
                <td>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('books.show', $book->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('books.edit', $book->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $books->links() !!}

@endsection
