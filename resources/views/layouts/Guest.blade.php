<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="description" content="Guest Layout for Bright Finance">
    <title>BF: Bright Finance - Guest</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&display=swap"></noscript>
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg bg-gradient-info border-radius-lg shadow-dark mt-4 py-2">
  <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">

    <!-- Logo -->
    <a href="/" class="navbar-brand d-flex align-items-center">
      <img src="assets/images/Bright v4.png" alt="Bright Finance" style="height: 4.3rem;">
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler text-success ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <span class="navbar-toggler-bar bar1"></span>
        <span class="navbar-toggler-bar bar2"></span>
        <span class="navbar-toggler-bar bar3"></span>
      </span>
    </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/features">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/About">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Contact">Contact</a>
                        </li>
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Sign Up</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-3">
        <div class="container">
            <p class="mb-0">© Copyright Bright Finance. All Rights Reserved.</p>
            <div class="social-links mt-2">
                <a href="#" class="me-3"><i class="socicon-twitter socicon"></i></a>
                <a href="#" class="me-3"><i class="socicon-facebook socicon"></i></a>
                <a href="#" class="me-3"><i class="socicon-instagram socicon"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>
