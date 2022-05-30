@component('mail::message')
# Order Shipped

@component('mail::panel')
    Your order has been shipped!
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'success'])
View Order No.: {{ $order->id }}
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
