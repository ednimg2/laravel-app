@extends('layout')

@section('content')
    <div class="row">
        <div class="col">
            <h1>Blog show</h1>
            <a href="{{ route('blogs.index') }}" class="btn btn-primary" title="Back">Back</a>
            <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
        </div>
    </div>

    <img src="{{ asset('assets/images/photo.jpg') }}">
    <a href="{{ url('helper/urls') }}">Helpers url</a>

    <div class="row">
        <div class="col">
            <h3>{{ $blog->title }}</h3>
            <span>{{ $blog->author }}</span>
            <p>{{ $blog->description }}</p>
        </div>
    </div>

    <hr>
    <h3>Audit logs</h3>
    <table>
        <tr>
            <th style="width: 200px">{{ __('Date') }}</th>
            <th>Changes</th>
        </tr>
        @foreach($blog->audits as $audit)
            <tr>
                <td>{{ $audit->created_at }}</td>
                <td>{{ $audit->context }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
@endsection
