<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <style>
        .ui-autocomplete-loading {
            background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
</head>
<body>

<div class="container">
    @yield('content')
</div>

@if(!\Illuminate\Support\Facades\Cookie::get('accpetCookie'))
    <div style="border: 1px solid black; padding: 10px; margin-top: 60px">
        <form action="{{route('cookies')}}" method="post">
            Pazymekite kad sutinkate su musu cookies politika....
            @csrf
            <input name="accept" type="submit" value="accept">
        </form>
    </div>
@endif

</body>
</html>
