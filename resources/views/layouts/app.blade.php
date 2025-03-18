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
    <title>Pesquisa de Mercado AmSilotti</title>
    <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('css/charts/coreui-chartjs.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/fontawesome/css/all.css') }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


    @vite(['', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>




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
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 150);
                }, 3000);
            }
        });
    </script>
    <script src="{{ asset('js/charts/chart.umd.js') }}"></script>
    <script src="{{ asset('js/charts/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('js/charts/index.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>



    {{-- google maps  --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKSzRBDhbBkhSbsqG6ijqDjdYL67termU&callback=initMap" async defer></script>


    <!-- Scripts multiselect -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>

<script>
    $(document).ready(function(){
        // Money mask (R$ 1.234,56)
        $('.money').mask('000.000.000.000.000,00', {reverse: true});

        // Phone mask (Brazilian format)
        $('.phone').mask('(00) 00000-0000');

        // CPF mask
        $('.cpf').mask('000.000.000-00', {reverse: true});

        // CNPJ mask
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true});

        // Date mask (dd/mm/yyyy)
        $('.date').mask('00/00/0000');

        // CEP mask
        $('.cep').mask('00000-000');

        $('.area').mask('##0.00', {
                reverse: true,
                translation: {
                    '0': {pattern: /\d/},
                    '9': {pattern: /\d/, optional: true},
                    '#': {pattern: /\d/, recursive: true}
                }
            });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleciona todos os elementos com o atributo data-coreui-toggle="tooltip"
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-coreui-toggle="tooltip"]'));

        // Inicializa os Tooltips para cada elemento
        tooltipTriggerList.forEach(function(element) {
            new coreui.Tooltip(element);
        });
    });
</script>


</body>

</html>
