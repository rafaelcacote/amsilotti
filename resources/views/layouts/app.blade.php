<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>CoreUI Free Bootstrap Admin Template</title>

    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/charts/coreui-chartjs.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])


  </head>
    <body>
       <!-- ======= Sidebar ======= -->
        <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
            @include('layouts.menu')
        </div>
        <!-- ======= Sidebar ======= -->
        <div class="wrapper d-flex flex-column min-vh-100">
          <header class="header header-sticky p-0 mb-4">
             <!-- ======= Topo ======= -->
             @include('layouts.topo')
            <!-- ======= Topo ======= -->
            <div class="container-fluid px-4">
              <!-- ======= Header ======= -->
              @include('layouts.navigation')
             <!-- ======= Header ======= -->
            </div>
          </header>

          <div class="body flex-grow-1">
            @yield('content')
          </div>
          <div class="body flex-grow-1">
            <div class="container-lg px-4">
            </div>
          </div>
           <!-- ======= Footer ======= -->
           @include('layouts.footer')
           <!-- ======= Footer ======= -->
        </div>
        <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>

        <script>
          const header = document.querySelector('header.header');

          document.addEventListener('scroll', () => {
            if (header) {
              header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
          });

        </script>
        <script>
        </script>
        <script src="{{ asset('js/charts/chart.umd.js') }}"></script>
        <script src="{{ asset('js/charts/coreui-chartjs.js') }}"></script>
        <script src="{{ asset('js/charts/index.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>
