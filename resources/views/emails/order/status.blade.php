@component('mail::message')
# Order status

@component('mail::panel')
    Order ID: {{ $order->id }}
@endcomponent

@component('mail::button', ['url' => url('orders/show', $order->id)])
    {{ $myName }}
@endcomponent

@component('mail::button', ['url' => url('orders/show', $order->id), 'color' => 'success'])
    {{ $myName }}
@endcomponent

@component('mail::table')
    | Laravel       | Table         | Example  |
    | ------------- |:-------------:| --------:|
    | Col 2 is      | Centered      | $10      |
    | Col 3 is      | Right-Aligned | $20      |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
