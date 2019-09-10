<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://bootswatch.com/3/readable/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->    
    <script>var base_url = '{{ url('/') }}';</script>
</head>
<body>
    <div id="app">

        <div class="top-bar">
            <div class="top-bar-wrap">
                <div class="top-bar-left"><p>Discount for the first booking</p></div>
                    <div class="top-bar-right">
                       
                            <p><a href="#">Support</a><a href="#">FAQ</a></p>
                            
                       
                    </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="jumbotron">
            <div class="container">
                <h1>Enjoy the trip!</h1>
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
                        <input name="check_out" type="text"  value="{{ old('check_out') }}" class="form-control datepicker" id="check_out" placeholder="Check out">
                    </div>
                    <div class="form-group">
                        <select name="room_size" class="form-control">
                            <option>Room size</option>
                            
                            <!-- Lecture 19 -->
                            @for($i=1;$i<=5;$i++)
                                @if( old('room_size') == $i )
                                <option selected value="{{$i}}">{{$i}}</option>
                                @else
                                <option value="{{$i}}">{{$i}}</option>
                                @endif
                            @endfor
                            
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Search</button>
                          @csrf            
                </form>

            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>        
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}"></script> <!-- Lecture 5 -->
        @stack('scripts') <!-- Lecture 20 -->
</body>
</html>
