<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://bootswatch.com/3/readable/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Be+Vietnam|Open+Sans|Roboto&display=swap" rel="stylesheet">

    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>var base_url = '{{ url('/') }}';</script>
</head>
<body>

    <div class="top-bar">
        <div class="top-bar-wrap">
            <div class="top-bar-left"><p>hotelsplus@gmail.com</p></div>
            <div class="top-bar-right">

                <p><a href="#">Search</a><a href="#">FAQ</a></p>


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
                <ul class="authentified dropdown">

                    <li class="dropdown">
                      <p class="dropdown-toggle text" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </p>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>    
                </div>
            </li>                     
            <li><a href="{{ route('adminHome') }}">admin</a></li>

        </ul>
        @endauth 
        @guest 
        <ul class="authentification">
            <li><a href="{{ route('login') }}">Login</a></li> 
            <li><a href="{{ route('register') }}">Sign in</a></li> 
        </ul>
        @endguest 
    </div>
</div>
</nav>

<section class="search" data-type="background">
    <div class="search-area">
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
</section>

<main class="py-4">
    @yield('content')
</main>

<div class="container-fluid">

    <div class="row mobile-apps">

        <div class="col-md-6 col-xs-12">

            <img src="{{ asset('images/mobile-app.png') }}" alt="" class="img-responsive center-block">
        </div>

        <div class="col-md-6 col-xs-12">
            <h1 class="text-center">Download mobile app.</h1>

            <a href="#"><img class="img-responsive center-block" src="{{ asset('images/google.png') }}" alt=""></a><br><br>
            <a href="#"><img class="img-responsive center-block" src="{{ asset('images/apple.png') }}" alt=""></a><br><br>
            <a href="#"><img class="img-responsive center-block" src="{{ asset('images/windows.png') }}" alt=""></a>

        </div>

    </div>

    <hr>

    <footer>

        <p class="text-center">&copy; 2017 HotelsPlus</p>

    </footer>

</div>        

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script> 
@stack('scripts') 
</body>
</html>
