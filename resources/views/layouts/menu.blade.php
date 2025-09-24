<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <!-- Logo completa -->
            <img class="sidebar-brand-full" src="{{ asset('img/logo.png') }}" alt="Logo" width="200" height="28">
            <!-- Logo reduzida (para o modo narrow) -->
            <img class="sidebar-brand-narrow" src="{{ asset('img/logomini.png') }}" alt="Logo" width="32"
                height="32">
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>

        @hasrole('cliente_amostra')
            <!-- Dashboard oculto para clientes amostra -->
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-house nav-icon"></i> Dashboard
                </a>
            </li>
        @endhasrole

        @hasrole('cliente_amostra')
            <!-- Menu simplificado para clientes amostra -->
        @else
            <li class="nav-title">Cadastros</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('controle_de_tarefas.index') }}">
                    <i class="fa fa-clipboard-list nav-icon"></i> Controle de Tarefas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('controle-pericias.index') }}">
                    <i class="fas fa-gavel me-2 nav-icon"></i> Controle de Perícias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('entrega-laudos-financeiro.index') }}">
                    <i class="fas fa-money-bill-wave nav-icon"></i> Financeiro Laudo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('agenda.index') }}">
                    <i class="fa-solid fa-calendar-days nav-icon"></i> Agenda</a>
            </li>

            <li class="nav-item"><a class="nav-link" href="{{ route('vistorias.index') }}">
                    <i class="fa fa-clipboard-check nav-icon"></i> Vistorias</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">
                    <i class="fa fa-user-tie nav-icon"></i> Clientes</a>
            </li>
        @endhasrole
        <li class="nav-title">Pesquisa de Mercado</li>

        @hasrole('cliente_amostra')
            <li class="nav-item"><a class="nav-link" href="{{ route('consulta.cliente.index') }}">
                    <i class="fa fa-search nav-icon"></i> Consulta de Imóveis</a>
            </li>
        @else
            <li class="nav-item"><a class="nav-link" href="{{ route('imoveis.index') }}">
                    <i class="fa fa-building nav-icon"></i> Imóveis</a>
            </li>
        @endhasrole

        @hasrole('cliente_amostra')
            <!-- Seções administrativas ocultas para clientes amostra -->
        @else
            <li class="nav-title">Gerenciamento</li>
            <li class="nav-item"><a class="nav-link" href="{{ route('membro-equipe-tecnicas.index') }}">
                    <i class="fa fa-users nav-icon"></i> Membro Equipe Técnica</a></li>
        @endhasrole
        @can('view pgm')
            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fa-solid fa-money-bill-transfer nav-icon"></i> PGM</a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('zonas.index') }}">
                            <i class="fa fa-map-marked-alt nav-icon"></i> Zonas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bairros.index') }}">
                            <i class="fa fa-map-marker-alt nav-icon"></i> Bairros - PGM
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vigencia_pgm.index') }}">
                            <i class="fa fa-calendar nav-icon"></i> Vigência PGM
                        </a>
                    </li>

                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('vias-especificas.index') }}" target="_top">
                            <i class="fa fa-road nav-icon"></i> PGM - Vias Específicas</a>
                    </li> -->

                </ul>
            </li>
        @endcan
        @can('view users')
            <li class="nav-title">Gerenciamento de Usuários</li>
            <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fa fa-user nav-icon"></i> Usuários</a>
            </li>
        @endcan

        @can('manage settings')
            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fa fa-shield-alt nav-icon"></i> Controle de Acesso</a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <i class="fa fa-user-tag nav-icon"></i> Perfis (Roles)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">
                            <i class="fa fa-key nav-icon"></i> Permissões
                        </a>
                    </li>
                    @can('manage permissions')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                                <i class="fa fa-cogs nav-icon"></i> Gerenciar Permissões
                            </a>
                        </li>
                    @endcan
                    <!-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('user-permissions.index') }}">
                                    <i class="fa fa-user-lock nav-icon"></i> Usuários & Permissões
                                </a>
                            </li> -->
                </ul>
            </li>
        @endcan
        @can('view feedback sistema')
            <li class="nav-item"><a class="nav-link" href="{{ route('feedback_sistema.index') }}">
                    <i class="fa fa-comment nav-icon"></i> Feedback do Sistema
                    @if ($feedbacksPendentesCount > 0)
                        <span
                            class="badge badge-sm bg-info ms-auto">{{ str_pad($feedbacksPendentesCount, 2, '0', STR_PAD_LEFT) }}</span>
                    @endif
                </a>
            </li>
        @endcan
</div>
