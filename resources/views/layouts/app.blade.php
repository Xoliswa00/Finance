<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BF : Bright Finance</title>
    <meta name="description" content="Bright Finance offers expert business consulting, financial solutions, and startup support in South Africa.">


  <!-- Primary SVG favicon (modern browsers) -->
<link rel="icon" type="image/svg+xml" href="Bright.svg">

<!-- PNG fallback for older browsers -->
<link rel="icon" type="image/png" href="/assets/images/bright.png">

<!-- Windows/IE fallback (ICO) -->
<link rel="shortcut icon" href="Bright.ico" type="image/x-icon">


    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>


    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons2/mobirise2.css">
    <link rel="stylesheet" href="assets/web/assets/mobirise-icons/mobirise-icons.css">
    <link rel="preload" as="style" href="assets/mobirise/css/mbr-additional.css">
    <link rel="stylesheet" href="assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="assets/socicon/css/styles.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/theme/css/style.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&display=swap">
    </noscript>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  



</head>

<body class="bg-gray-200  responsive">
    <div class="container-fluid  ">
        <div class="row">
            <div class="col-12">

                <nav class="navbar navbar-expand-lg bg-gradient-info border-radius-lg shadow-dark mt-4 py-2">
                    <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">

                       <a href="/" class="navbar-brand d-flex align-items-center">
    <picture>
        <source srcset="assets/images/Bright.svg" type="image/svg+xml">
        <img src="assets/images/Bright v4.png" alt="Bright Finance" style="height: 4.3rem;">
    </picture>
</a>


                        <!-- Toggler -->
                        <button class="navbar-toggler text-success ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </span>
                        </button>

                        <!-- Collapsible content -->
                        <div class="collapse navbar-collapse" id="navigation">
                            <!-- Left Side -->
                            <ul class="navbar-nav mx-auto text-uppercase">
                                <!-- Add items here if needed -->
                            </ul>

                            <!-- Right Side -->
                            <ul class="navbar-nav text-uppercase ms-auto">
                                @guest
                                <li class="nav-item">
                                    <a class="nav-link btn bg-gradient-light me-2" href="/"><span class="mbri-home mbr-iconfont"></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn bg-gradient-light me-2" tooltip="" href="{{ route('features') }}"><span class="mbri-features mbr-iconfont"></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn bg-gradient-light me-2" href="{{ route('About') }}"><span class="mobi-mbri-info mbr-iconfont"></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn bg-gradient-light me-2" href="{{ route('Contact') }}"><span class="mobi-mbri-phone mbr-iconfont"></span></a>
                                </li>
                                @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link btn bg-gradient-light me-2" href="{{ route('login') }}"><span class="mobi-mbri-user-2 mbr-iconfont"> Login</span></a>
                                </li>
                                @endif
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link btn text-white me-2" href="{{ route('register') }}"><span class="mobi-mbri-contact-form mbr-iconfont"> Sign Up</span></a>
                                </li>
                                @endif
                                @else
                                <li class="nav-item">
                                    <a class="nav-link btn bg-gradient-light me-2" href="/home"><span class="">Dashboard</span></a>
                                </li>
                             
                                  <li class="nav-item d-flex align-items-center">
            <a class=" show dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="material-icons opacity-10">logout</i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>



                <!-- Navbar -->




            </div>

        </div>
    </div>


   <br>
        <!-- nav -->
        <main class="flex-fill">
            <br>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            @yield('content')
        </main>



        <footer class=" text-white py-5 mt-auto">
    <section data-bs-version="5.1" class="footer3 cid-tFrUpHHGnk" once="footers" id="footer3-g">
        <div class="container">
            <div class="row justify-content-between align-items-center">

                <!-- Branding -->
                <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="fw-bold text-uppercase">Bright Finance</h5>
                    <p class="text-muted small">Your trusted companion for smarter money decisions.</p>
                </div>

                <!-- Social Icons -->
                <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                    <div class="d-flex justify-content-center gap-3">
                        <a href="https://facebook.com" target="_blank" class="text-white fs-4">
                            <i class="socicon-facebook mbr-iconfont"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="text-white fs-4">
                            <i class="socicon-twitter mbr-iconfont"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="text-white fs-4">
                            <i class="socicon-instagram mbr-iconfont"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="text-white fs-4">
                            <i class="socicon-youtube mbr-iconfont"></i>
                        </a>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="col-12 col-md-4 text-center text-md-end">
                    <p class="small mb-0 opacity-75">
                        © {{ date('Y') }} Bright Finance. All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </section>
</footer>




        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>





    </body>

</html>