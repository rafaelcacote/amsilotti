@extends('layouts.login')

@section('content')
    
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #fff;
        }

        .login-main-container {
            min-height: 100vh;
            display: flex;
        }

        .login-left {
            background: url('{{ asset('/img/login.jpg') }}') center center no-repeat #18181b;
            background-size: cover;
            color: #fff;
            width: 50%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 3rem 2rem 3rem;
            position: relative;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(24, 24, 27, 0.7);
            z-index: 1;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .login-logo,
        .login-quote,
        .login-quote-author {
            position: relative;
            z-index: 2;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .login-logo img {
            height: 50px;
        }

        .login-quote {
            font-size: 1.1rem;
            color: #e4e4e7;
            margin-bottom: 0.2rem;
            min-height: 48px;
            transition: opacity 0.4s;
        }

        .login-quote-author {
            font-size: 0.95rem;
            color: #a1a1aa;
            min-height: 20px;
            transition: opacity 0.4s;
        }

        .login-right {
            width: 50%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        .login-card {
            width: 100%;
            max-width: 380px;
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 24px 0 rgba(31, 38, 135, 0.06);
        }

        .login-title {
            font-weight: 600;
            font-size: 1.5rem;
            color: #18181b;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #71717a;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 500;
            color: #18181b;
        }

        .form-control {
            background: #f4f4f5;
            border: 1px solid #e4e4e7;
            border-radius: 6px;
            font-size: 1rem;
            padding: 0.7rem 1rem;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.1rem rgba(99, 102, 241, 0.08);
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .btn-login {
            background: #5c54d3;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            padding: 0.7rem 0;
            margin-top: 0.5rem;
            transition: background 0.2s;
            position: relative;
            overflow: hidden;
        }

        .btn-login[disabled] {
            opacity: 0.7;
            cursor: not-allowed;
        }

 .btn-login:hover {
    background: #4438ca; /* tom mais profundo, elegante, ainda roxo */
}

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #fff;
            border-radius: 50%;
            border-top: 2px solid #6366f1;
            animation: spin 0.7s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .register-link {
            color: #71717a;
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.98rem;
        }

        .register-link a {
            color: #6366f1;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 991.98px) {
            .login-main-container {
                flex-direction: column;
            }

            .login-left,
            .login-right {
                width: 100%;
                min-height: 250px;
                border-radius: 0;
            }

            .login-right {
                min-height: 60vh;
            }
        }
    </style>
    <div class="login-main-container">
        <div class="login-left">
            <div class="login-logo">
                <img src="{{ asset('/img/logo.png') }}" alt="Logo">

            </div>
            <div></div>
            
        </div>
        <div class="login-right">
            <div class="login-card">
                <div class="login-title">Acesse sua conta</div>
                <div class="login-subtitle">Entre com seu e-mail e senha para continuar</div>
                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf
                    <div class="mb-2">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email"
                            name="email" value="{{ old('email') }}" required autofocus placeholder="Digite seu e-mail">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password"
                            name="password" required placeholder="Digite sua senha">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-login" id="btn-login">
                        <span id="btn-login-text">Entrar</span>
                        <span id="btn-login-loading" style="display:none;"><span class="spinner"></span>Carregando...</span>
                    </button>
                </form>
                 <div class="register-link">
                    Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a>
                </div> 
            </div>
        </div>
    </div>
    <script>
    
        // Loading no bot�0�0o Entrar
        document.getElementById('login-form').addEventListener('submit', function(e) {
            document.getElementById('btn-login').setAttribute('disabled', 'disabled');
            document.getElementById('btn-login-text').style.display = 'none';
            document.getElementById('btn-login-loading').style.display = 'inline-block';
        });
    </script>
@endsection
