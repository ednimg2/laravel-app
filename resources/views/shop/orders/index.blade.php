@extends('layout')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

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
                <td>
                    <a href="{{ url('orders/send-email', $order->id) }}" class="btn btn-primary">Send email</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">rows not found!</td>
            </tr>
        @endforelse
    </table>
@endsection
