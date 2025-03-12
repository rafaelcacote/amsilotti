<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
        <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#full"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
            <use xlink:href="assets/brand/coreui.svg#signet"></use>
        </svg>
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
        onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-camera nav-icon"></i>
            Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span></a></li>
    <li class="nav-title">Cadastros</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('ordens-de-servico.index') }}">
            <i class="fas fa-clipboard-list nav-icon"></i> Ordem de Serviços</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('vistorias.index') }}">
            <i class="fas fa-clipboard-check nav-icon"></i> Vistorias</a></li>
    <li class="nav-title">Pesquisa de Mercado</li>

    <li class="nav-item"><a class="nav-link" href="#">
            <i class="fas fa-building nav-icon"></i> Imóveis</a></li>

    <li class="nav-title">Gerenciamento</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('membro-equipe-tecnicas.index') }}">
        <i class="fa-solid fa-users nav-icon"></i> Membro Equipe Técnica</a></li>
    <li class="nav-group" aria-expanded="true">
        <a class="nav-link nav-group-toggle" href="#">
            <i class="fa-solid fa-money-bill-transfer nav-icon"></i> PGM
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
            <li class="nav-item"><a class="nav-link" href="500.html" target="_top">
                    <i class="fas fa-road nav-icon"></i> PGM - Vias Específicas</a></li>
        </ul>
    </li>
    <li class="nav-title">Gerenciamento de Usuários</li>
    <li class="nav-item"><a class="nav-link" href="charts.html">
            <i class="fas fa-chart-pie nav-icon"></i> Usuários</a></li>

</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
