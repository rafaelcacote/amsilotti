<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v5.2.0
* @link https://coreui.io/product/free-bootstrap-admin-template/
* Copyright (c) 2025 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
-->

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
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="node_modules/simplebar/dist/simplebar.css">
    <link rel="stylesheet" href="css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/coreui.min.css') }}" rel="stylesheet">
    @vite(['', 'resources/js/app.js'])
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="css/examples.css" rel="stylesheet">
    <script src="js/config.js"></script>
    <script src="js/color-modes.js"></script>
</head>

<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="card-body">
                                    <h1>Entrar</h1>
                                    <p class="text-body-secondary">Entre na sua conta</p>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input class="form-control" id="email" class="block mt-1 w-full"
                                            type="email" name="email" :value="old('email')" required autofocus
                                            autocomplete="username">

                                        @error('email')
                                            <div class="text-sm text-red-600 mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="input-group mb-4"><span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input id="password" class="form-control block mt-1 w-full" type="password"
                                            name="password" required autocomplete="current-password">
                                        {{-- @if ($messages)
                            <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
                                @foreach ((array) $messages as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        @endif --}}

                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary px-4"
                                                type="button">Entrar</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-link px-0" type="button">Esqueceu a
                                                senha?</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <h2>Cadastre-se</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.</p>
                                    <button class="btn btn-lg btn-outline-light mt-3" type="button">Cadastre-se
                                        agora!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
    {{-- <script src="node_modules/simplebar/dist/simplebar.min.js"></script> --}}
    <script>
        const header = document.querySelector('header.header');

        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
    </script>
    <script></script>
</body>

</html>
