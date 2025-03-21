<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
        <!-- Logo completa -->
        <img class="sidebar-brand-full" src="/img/logo.png" alt="Logo" width="200" height="28">
        <!-- Logo reduzida (para o modo narrow) -->
        <img class="sidebar-brand-narrow" src="/img/logomini.png" alt="Logo" width="32" height="32">
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
        onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-home nav-icon"></i>
            Dashboard</a></li>
    <li class="nav-title">Cadastros</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('controle_de_tarefas.index') }}">
            <i class="fas fa-clipboard-list nav-icon"></i> Controle de Tarefas</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('vistorias.index') }}">
            <i class="fas fa-clipboard-check nav-icon"></i> Vistorias</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">
                <i class="fas fa-user-tie nav-icon"></i> Clientes</a></li>
    <li class="nav-title">Pesquisa de Mercado</li>

    <li class="nav-item"><a class="nav-link" href="{{ route('imoveis.index') }}">
            <i class="fas fa-building nav-icon"></i> Imóveis</a></li>

    <li class="nav-title">Gerenciamento</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('membro-equipe-tecnicas.index') }}">
            <i class="fas fa-users nav-icon"></i> Membro Equipe Técnica</a></li>
    <li class="nav-group" aria-expanded="true">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="fa-solid fa-money-bill-transfer"></i> PGM
        </a>
        <ul class="nav-group-items compact" style="height: auto;">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('zonas.index') }}">
                    <i class="fas fa-map-marked-alt nav-icon"></i> Zonas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('bairros.index') }}">
                    <i class="fas fa-map-marker-alt nav-icon"></i> Bairros
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('valores-bairros.index') }}">
                    <i class="fas fa-map-signs nav-icon"></i> PGM - Bairro
                </a>
            </li>
            {{-- <li class="nav-item"><a class="nav-link" href="500.html" target="_top">
                    <i class="fas fa-road nav-icon"></i> PGM - Vias Específicas</a></li> --}}
        </ul>
    </li>
    <li class="nav-title">Gerenciamento de Usuários</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-user nav-icon"></i> Usuários</a></li>

</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
