@extends('layout')

@section('content')
<table class="table">
    <tr>
        <td>Name</td>
        <td>ISO2</td>
        <td>Active</td>
        <td>-</td>
    </tr>
    @forelse($countries as $country)
        <tr>
            <td>{{ $country->name }}</td>
            <td>{{ $country->iso_code_2 }}</td>
            <td>{{ $country->active }}</td>
            <td></td>
        </tr>
    @empty
        <tr>
            <td colspan="5">rows not found!</td>
        </tr>
    @endforelse
</table>
@endsection
