@extends('layout')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Add new Blog</h1>
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="Back">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @if ($errors->has('title'))
                <div class="alert alert-warning">
                    {{ $errors->first('title') }}
                    <ul>
                    @foreach($errors->get('title') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            @if ($errors->has('author'))
                <div class="alert alert-primary">
                    <ul>
                        @foreach($errors->get('author') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            <form action="{{ route('blogs.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Title:</strong>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Title">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Author:</strong>
                            <input type="text" name="author" value="{{ old('author') }}" class="form-control" placeholder="Author">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Description:</strong>
                            <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" id="flexCheckChecked" class="form-check-input"
                                @if (old('is_active'))
                                   checked
                                @endif
                            >
                            <label class="form-check-label" for="flexCheckChecked">
                                Active
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
