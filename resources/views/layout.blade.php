<!DOCTYPE html>
<html>
<head>
    <title>@yield('page_title', 'Default title')</title>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">Laravel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('books.index') }}">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blogs.index') }}">Blog</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
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

@stack('scripts')

</body>
</html>
