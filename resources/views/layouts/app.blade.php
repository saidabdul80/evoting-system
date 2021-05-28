<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <link href="{{ asset('aos/aos.css') }}" rel="stylesheet"> -->
    <script src="{{ asset('js/jquery.js') }}" defer></script>
    <script src="{{ asset('simplyScroll/jquery.simplyscroll.min.js') }}" defer></script>
    <script src="{{ asset('js/sweetalert.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('simplyScroll/jquery.simplyscroll.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/animate.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">
    <script src="{{ asset('aos/aos.js') }}" defer></script>
    <link href="{{ asset('css/boostrap.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
</head>
<body>
        <!--onclick progress loader  -->
    <div class="sysloader p-loader-bg-transparent p-display-none" id="system-loader">
      <div class="lds-dual-ring"></div>
    </div>
    <!-- end onclick  progress loader-->
    <!--  -->
    <!-- page loader -->
    <!-- <div class="sysloader p-loader-bg-dark p-display-flex" id="system-loader2">
      <div class="lds-dual-ring"></div>
    </div> -->
    <div id="app">
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
                        @if(!session()->has('user'))                        
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif                            
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>                           
                        @if(session('user')??'' != '')                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ session('user')->fname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="\dashboard" >
                                        Dashboard
                                    </a>
                                    <a class="dropdown-item" href="\voting" >
                                        Voting
                                    </a>
                                    <a class="dropdown-item" href="\results" >
                                        Results
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <div class="footer">
            (c)2021 Develop by MSUIT visit www.msuit.com.ng
        </div>
    </div>
</body>
</html>
