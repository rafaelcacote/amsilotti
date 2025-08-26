<div class="container-fluid border-bottom px-4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <button class="header-toggler" type="button"
        onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
        style="margin-inline-start: -14px;">
        <i class="fas fa-bars fa-lg"></i>
    </button>
    <ul class="header-nav d-none d-lg-flex">
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
        {{-- <li class="nav-item"><a class="nav-link" href="#">Perfil Usuário</a></li> --}}
    </ul>
    <ul class="header-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">
                <i class="fas fa-bell fa-lg"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
                <i class="fas fa-list fa-lg"></i></a></li>
        <li class="nav-item"><a class="nav-link" href="#">
                <i class="far fa-envelope-open fa-lg"></i></a></li>
        <li class="nav-item dropdown"><a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="false">
                <strong>{{ auth()->user()->name }}</strong></a>
            <div class="dropdown-menu dropdown-menu-end pt-0">
                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('users.edit-password') }}">
                    <i class="fas fa-key me-2"></i> Alterar Senha</a><a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form-name').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair</a>
                <form id="logout-form-name" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

    <ul class="header-nav">
        <li class="nav-item py-1">
            <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
        </li>


        <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#"
                role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset('img/user.png') }}"
                        alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end pt-0">

                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('users.edit-password') }}">
                    <i class="fas fa-user me-2"></i> Alterar Senha</a><a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</div>
