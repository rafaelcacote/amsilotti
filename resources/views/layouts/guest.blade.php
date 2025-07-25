<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }
            .logo-container {
                animation: fadeInDown 0.8s ease-out;
            }
            .form-container {
                animation: fadeInUp 0.8s ease-out;
                backdrop-filter: blur(8px);
                background: rgba(255,255,255,0.98);
                box-shadow: 0 8px 32px 0 rgba(31,38,135,0.15);
                border-radius: 1rem;
                border: 1px solid #e0e7ff;
                max-width: 370px;
                width: 100%;
                padding: 2rem 1.5rem;
            }
            @media (max-width: 480px) {
                .form-container {
                    padding: 1rem 0.5rem;
                    max-width: 98vw;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center p-6">
            <!-- Logo e Mensagem de Boas-vindas -->
            <div class="logo-container mb-6 text-center">
                <div class="mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo Amsillote" class="w-16 h-16 mx-auto drop-shadow-lg rounded-full border-2 border-white/80 bg-white/80 p-1">
                </div>
                <div class="text-white">
                    <h1 class="text-2xl font-bold mb-2 drop-shadow">Seja bem-vindo ao Sistema Amsillote!</h1>
                    <p class="text-base opacity-90 max-w-md mx-auto leading-relaxed">
                        Esta é uma tela de pré-cadastro para acesso às amostras de Pesquisa de Mercado.<br>
                        <span class="text-xs text-white/80">Complete seus dados para ter acesso ao sistema.</span>
                    </p>
                </div>
            </div>

            <!-- Formulário -->
            <div class="form-container w-full max-w-sm shadow-xl rounded-xl border border-white/30 flex flex-col gap-2">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
