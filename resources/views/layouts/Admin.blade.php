<!--
=========================================================
* Material Dashboard 2 - v3.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BF : Bright Finance</title>


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
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../../assets/css/material-kit.css?v=3.0.4" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href='assets/css/fullcalendar.css' rel='stylesheet' />
<link href='assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='assets/js/jquery-1.10.2.js' type="text/javascript"></script>
<script src='assets/js/jquery-ui.custom.min.js' type="text/javascript"></script>
<script src='assets/js/fullcalendar.js' type="text/javascript"></script>

</head>

<body class="g-sidenav-show  bg-gray-300">
  
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-x1 my-4 fixed-start ms-2   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('admin.dashboard') }}" target="_blank">
        <img src="assets/images/Bright v4.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white"> BF : Admin Portal</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
     
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white  " href="{{ route('admin.users') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">User Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('forecast') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Feedback & Review</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{ route('Balancesheet') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">notifications</i>
            </div>
            <span class="nav-link-text ms-1">Reports & Analytics</span>
          </a>
        </li>
       
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Other Pages</h6>
        </li>
      
      
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('home')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">settings</i>
            </div>
            <span class="nav-link-text ms-1">Configure & Settings</span>
          </a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('Goals.Matter')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">view_in_ar</i>
            </div>
            <span class="nav-link-text ms-1">Management </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('budgets.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Tasks Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('transactions.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">info</i>
            </div>
            <span class="nav-link-text ms-1">Database Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('master.index')}}">
            <div class=" text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">add</i>
            </div>
            <span class="nav-link-text ms-1">subscriptions</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="{{route('master.index')}}">
            <div class=" text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">money</i>
            </div>
            <span class="nav-link-text ms-1">Financials</span>
          </a>
        </li>
      
    
       
      </ul>
     
    </div>
   
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-3  mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
      

          <div class="navbar-brand">
            <span class="navbar-logo img">
                <a href="{{ route('admin.dashboard') }}" class="nav-link  text-body p-0" id="navbarBlur">
                    <img src="assets/images/Bright v4.png" class="img" alt="Bright Finance" style="height: 4.3rem;">
                </a>
              
            </span>
       

        </div>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              
            </div>
          
          </div>
          <ul class="navbar-nav  justify-content-end ">
           
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>


            </li>
            
          
            <li class="nav-item d-flex align-items-center">
              <a class="nav-link text-dark " href="{{ route('profile.index') }}">
                <i class="material-icons opacity-10">notifications</i>
              
              </a>
            </li>
        
          
            
          
         
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/sign-in.html" title="Sign out" class="nav-link text-body font-weight-bold px-0" >
              
             
              </a>
              <a class=" show dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="material-icons opacity-10">logout</i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">

      <Section>
        @yield('content')

      </Section>
  



     
    </div>
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
 
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>


  <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>