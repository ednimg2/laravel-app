@extends('components.column-2')

@section('page_title')
    Books
@endsection

@section('body')
    <div class="row">
        <div class="col-lg-12 my-2">
            <div class="pull-left">
                <h2>Books CRUD</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('books.create') }}"> Create New Book</a>
                <a class="btn btn-primary" href="{{ route('books.export') }}">Export list</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{ \Illuminate\Support\Facades\Cookie::get('pma') }}

    <form action="{{ route('books.index') }}" method="get">
        <label for="search">Search</label>
        <input id="search" type="text" name="search" placeholder="Insert book title" value="{{ request('search') }}">
        <input type="submit">
    </form>

    {{-- @if ($books) --}}
    <table class="table table-bordered my-2">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>-</th>
            <th width="280px">Action</th>
        </tr>
        @forelse ($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->description }}</td>
                <td>
                    @switch($book->id)
                        @case(36)
                        ID: {{ $book->id }}
                        @break
                        @case(33)
                        Kitas id
                        @break
                        @default
                        Default
                    @endswitch
                </td>
                <td>
                    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('books.show', $book->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('books.edit', $book->id) }}">Edit</a>

                        @if($book->file)
                            <a class="btn btn-success" target="_blank" href="{{ route('books.download', $book->id) }}">Download</a>
                        @endif

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <x-button type="success" btnName="Pirmas"></x-button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Nėra įrašų</td>
            </tr>
        @endforelse
    </table>

    {{--
    {!! $books->withQueryString()->links() !!}
    @else
        <h3>Nieko neradome</h3>
    @endif
    --}}

    @for ($i = 1; $i <= 10; $i++)
        <div>$i = {{ $i }}</div>
    @endfor

    @php
        $i = 1
    @endphp

    @while($i < 10)
        <div>{{ $i++ }}</div>
    @endwhile

    <script>
        $( function() {

            $("#search").autocomplete({
                source: "{{ route('books.autocomplete') }}",
                minLength: 2,
                select: function( event, ui ) {
                    // console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
                    window.location.replace('http://localhost/books/' + ui.item.value );
                }
            });
        } );
    </script>
@endsection

@push('scripts')
    <script>
        //alert('Hello');
    </script>
@endpush
