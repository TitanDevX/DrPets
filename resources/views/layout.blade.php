<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>DrPets - @yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('img/drpets.png') }}" alt="Logo" style="width: 100px; height: auto;">
                </a>
    
                <!-- Toggle Button for Small Screens -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <!-- Login and Register buttons if the user is not logged in -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <!-- Dashboard if the user is logged in -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @endguest
    
                        <!-- Language Switcher -->
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="languageSwitcher">Language</a>
                            <ul class="dropdown-menu" aria-labelledby="languageSwitcher">
                                <li><a class="dropdown-item" href="{{ route('login', ['lang' => 'en']) }}">English</a></li>
                                <li><a class="dropdown-item" href="{{ route('login', ['lang' => 'ar']) }}">Arabic</a></li>
                                <li><a class="dropdown-item" href="{{ route('login', ['lang' => 'fr']) }}">French</a></li>
                            </ul>
                        </li>
    
                        <!-- Dark Theme Toggle -->
                        <li class="nav-item">
                            <button class="btn btn-dark" id="themeToggle">Dark Theme</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    
        <script>
            // Dark theme toggle functionality
            document.getElementById('themeToggle').addEventListener('click', function() {
                document.body.classList.toggle('bg-dark');
                document.body.classList.toggle('text-white');
            });
        </script>
        <div class="container">
            @yield('content')
        </div>

    </body>
</html>