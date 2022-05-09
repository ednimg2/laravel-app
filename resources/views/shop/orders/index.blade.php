@extends('layout')

@section('content')
    <table class="table">
        <tr>
            <td>Order ID</td>
            <td>Status</td>
            <td>Name</td>
            <td>Email</td>
            <td>Phone</td>
            <td>Delivery method</td>
            <td>Payment method</td>
            <td>Country</td>
            <td>Created At</td>
            <td>-</td>
        </tr>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->delivery_method }}</td>
                <td>{{ $order->payment_method }}</td>
                <td>{{ $order->country_name }}</td>
                <td>{{ $order->created_at }}</td>
                <td></td>
            </tr>
        @empty
            <tr>
                <td colspan="5">rows not found!</td>
            </tr>
        @endforelse
    </table>
@endsection
