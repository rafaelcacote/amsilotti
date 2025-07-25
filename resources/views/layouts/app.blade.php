<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Bootstrap 5 CDN para garantir visual moderno -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/examples.css" rel="stylesheet">
    <script src="js/config.js"></script>
    <script src="js/color-modes.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- fontawesome 6.7.2 --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/cliente-autocomplete.js') }}"></script>

    @yield('styles')
    @yield('head')
</head>

<body class="font-sans antialiased">
    <!-- ======= Sidebar ======= -->

    @include('layouts.menu')

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
            <div class="custom-container">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Situação Tarefa</strong>
                            <small>Agora</small>
                            <button type="button" class="btn-close" data-coreui-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                        <div class="toast-body"></div>
                    </div>
                </div> -->

                @yield('content')
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

    <!-- Scripts multiselect -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>

    <!--<script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                theme: "bootstrap-5",
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
            });
        });
    </script>-->

    <script>
        $(document).ready(function() {
            const $select = $('#bairro_id');

            $select.select2({
                theme: "bootstrap-5",
                placeholder: $select.data('placeholder'),
                closeOnSelect: false,
            });

            $select.on('select2:open', function() {
                // Timeout garante que o campo de pesquisa já esteja na DOM
                setTimeout(function() {
                    let searchField = document.querySelector(
                        '.select2-container--bootstrap-5 .select2-search__field');
                    if (searchField) {
                        searchField.focus();
                    }
                }, 100);
            });
        });
    </script>

    <script>
        $(".js-example-disabled").select2({
            theme: "bootstrap-5",
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>


    <script>
        $(document).ready(function() {
            // Money mask (R$ 1.234,56)
            $('.money').mask('000.000.000.000.000,00', {
                reverse: true
            });

            // Phone mask (Brazilian format)
            $('.phone').mask('(00) 00000-0000');

            // CPF mask
            $('.cpf').mask('000.000.000-00', {
                reverse: true
            });

            // CNPJ mask
            $('.cnpj').mask('00.000.000/0000-00', {
                reverse: true
            });

            // Date mask (dd/mm/yyyy)
            $('.date').mask('00/00/0000');

            // CEP mask
            $('.cep').mask('00000-000');

            $('.area').mask('##0,00', {
                reverse: true,
                translation: {
                    '0': {
                        pattern: /\d/
                    },
                    '9': {
                        pattern: /\d/,
                        optional: true
                    },
                    '#': {
                        pattern: /\d/,
                        recursive: true
                    }
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

    @yield('scripts')
</body>

</html>
