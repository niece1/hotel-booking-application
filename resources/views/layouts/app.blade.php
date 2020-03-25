<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://bootswatch.com/3/readable/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://kit.fontawesome.com/8a06e21644.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Be+Vietnam|Open+Sans|Roboto&display=swap" rel="stylesheet">


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        var base_url = '{{ url(' / ') }}';
    </script>
</head>

<body>

    <div class="top-bar">
        <div class="top-bar-wrap">
            <div class="top-bar-left">
                <p>hotelsplus@gmail.com</p>
            </div>
            <div class="top-bar-right">

                <p><a href="#">About</a><a href="#">FAQ</a></p>

            </div>
        </div>
    </div>

    <nav class="navigation">

        <div class="navigation-wrapper">
            <div class="navigation-wrapper-left">
                <a class="logo" href="{{ route('home') }}">HotelsPlus</a>
            </div>

            <div class="navigation-wrapper-right">
                @auth
                <ul class="authentified">

                    <li class="dropdown">
                        <p class="dropdown-toggle text" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" style="cursor: pointer;" aria-expanded="false">
                            {{ Auth::user()->name }}<i class="fas fa-sort-down"></i>
                        </p>
                        <div class="dropdown-menu dropdown-custom" aria-labelledby="dropdownMenuButton">
                            <ul class="dropdown-custom-menu">
                                <li><a class="dropdown-item" style="line-height: 40px;" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                <li><a href="{{ route('adminHome') }}">Admin</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
                @endauth
                @guest
                <ul class="authentification">
                    <li><a href="{{ route('login') }}" style="line-height: 90px;">Login</a></li>
                    <li><a href="{{ route('register') }}" style="line-height: 90px;">Sign in</a></li>
                </ul>
                @endguest
            </div>
        </div>
    </nav>

    <section class="search" data-type="background">

        <h1>Book your weekend</h1>
        <p>A platform for tourists and owners of tourist facilities. Find the original place for the holidays!</p>
        <p>Place your home on the site and let yourself be found by many tourists!</p>
        <form action="{{ route('roomSearch') }}" method="POST" class="form-inline">
            <div class="form-group">
                <label class="sr-only" for="city">City</label>
                <input name="city" type="text" value="{{ old('city') }}" class="form-control autocomplete" id="city" placeholder="City">
            </div>
            <div class="form-group">
                <label class="sr-only" for="day_in">Check in</label>
                <input name="check_in" type="text" value="{{ old('check_in') }}" class="form-control datepicker" id="check_in" placeholder="Check in">
            </div>

            <div class="form-group">
                <label class="sr-only" for="day_out">Check out</label>
                <input name="check_out" type="text" value="{{ old('check_out') }}" class="form-control datepicker" id="check_out" placeholder="Check out">
            </div>
            <div class="form-group">
                <select name="room_size" class="form-control">
                    <option>Room size</option>

                    @for($i=1;$i<=5;$i++) @if( old('room_size')==$i ) <option selected value="{{$i}}">{{$i}}</option>
                        @else
                        <option value="{{$i}}">{{$i}}</option>
                        @endif
                        @endfor

                </select>
            </div>
            <button type="submit" class="btn btn-danger">Search</button>
            @csrf
        </form>

    </section>

    @yield('content')

    <div class="pre-footer">

        <div class="pre-footer-wrapper">

            <div class="logo-footer">
                <h4>HotelsPlus</h4>
                <p>Наше приложение предоставляет возможность бесплатной аренды номеров, а собственникам жилья сдать в аренду свой объект недвижимости.</p>

            </div>

            <div class="сontacts-footer">
                <h4>Контакты</h4>
                <p>Dialog: + 375 29 485 4569</p>
                <p>life:): + 375 25 368 5485</p>
                <p>Email: hotelsplus@gmail.com</p>
            </div>

            <div class="account">
                <h4>Аккаунт</h4>
                <p><a href="{{ route('login') }}">Мой аккаунт</a></p>
                <p><a href="{{ route('register') }}">Зарегистрироваться</a></p>
            </div>

        </div>

    </div>

    <footer>

        <p class="text-center">&copy;HotelsPlus {{ date('Y') }}</p>

    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>