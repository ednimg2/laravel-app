@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="pull-left">
                <h2>Edit Book</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('books.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @error('title')
        <div class="alert alert-warning">{{ $message }}</div>
    @enderror

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    {{ old('title') }}
                    <input type="text" name="title" value="{{ $book->title }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ $book->description }}</textarea>
                </div>
            </div>


            @if($book->file)
                <div class="mb-3">
                    <a href="{{asset($book->file)}}">file with assets</a>
                    <a href="{{ route('books.download', $book->id) }}" >File</a>
                </div>
            @endif

            <div class="mb-3">
                <label for="formFile" class="form-label">Default file input example</label>
                <input class="form-control" type="file" id="formFile" name="file">
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>

    </form>
@endsection
