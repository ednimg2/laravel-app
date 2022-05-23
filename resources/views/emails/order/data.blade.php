<style>
    h2 {
        color: red;
    }

    span {
        font-weight: bold;
    }

</style>

<h2>Order data</h2>

<span>Name:</span> {{ $order->first_name }} {{ $order->last_name }}<br>
Email: {{ $order->email }}<br>
Phone: {{ $order->phone }}
<br><br>
First name: {{ $first_name }}
