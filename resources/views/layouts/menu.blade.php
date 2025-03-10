<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
      <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
        <use xlink:href="assets/brand/coreui.svg#full"></use>
      </svg>
      <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
        <use xlink:href="assets/brand/coreui.svg#signet"></use>
      </svg>
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
  </div>
  <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item"><a class="nav-link" href="index.html">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-speedometer"></use>
        </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span></a></li>
    <li class="nav-title">Cadastros</li>
    <li class="nav-item"><a class="nav-link" href="{{ route('ordens-de-servico.index')}}">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-drop"></use>
        </svg> Ordem de Serviços</a></li>
    <li class="nav-item"><a class="nav-link" href="typography.html">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-pencil"></use>
        </svg> Vistorias</a></li>
    <li class="nav-title">Pesquisa de Mercado</li>

    <li class="nav-item"><a class="nav-link" href="charts.html">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-chart-pie"></use>
        </svg> Imóveis</a></li>
        <li class="nav-title">Gerenciamento de Usuários</li>
        <li class="nav-item"><a class="nav-link" href="charts.html">
            <svg class="nav-icon">
              <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-chart-pie"></use>
            </svg> Usuários</a></li>

  </ul>
  <div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
  </div>
