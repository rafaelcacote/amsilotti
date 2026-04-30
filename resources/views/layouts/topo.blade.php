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
        <li class="nav-item dropdown">
            <a class="nav-link position-relative" href="#" id="notificacoesBell" data-coreui-toggle="dropdown"
                aria-expanded="false" aria-label="Notificações">
                <i class="fas fa-bell fa-lg"></i>
                <span id="notificacoesBellBadge"
                    class="position-absolute badge rounded-pill bg-danger border border-light d-none notificacao-badge-pulsante"
                    style="top: 1px; right: -3px; min-width: 18px; height: 18px; font-size: 10px; line-height: 1;">
                    <span id="notificacoesBellBadgeCount" aria-hidden="true"></span>
                    <span id="notificacoesBellBadgeLabel" class="visually-hidden">Novas notificações</span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-0 shadow-sm" aria-labelledby="notificacoesBell"
                style="min-width: 340px;">
                <div class="px-3 py-2 border-bottom bg-light">
                    <strong class="small">Notificações</strong>
                </div>
                <div id="notificacoesBellList" class="py-1">
                    <div class="px-3 py-2 text-muted small">Carregando...</div>
                </div>
            </div>
        </li>
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

<style>
    .notificacao-badge-pulsante {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        animation: notificacao-badge-pulse 1.8s ease-in-out infinite;
        transform-origin: center;
    }

    @keyframes notificacao-badge-pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.45);
        }

        50% {
            transform: scale(1.08);
            box-shadow: 0 0 0 5px rgba(220, 53, 69, 0.12);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .notificacao-badge-pulsante {
            animation: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bellBadge = document.getElementById('notificacoesBellBadge');
        const bellBadgeCount = document.getElementById('notificacoesBellBadgeCount');
        const bellBadgeLabel = document.getElementById('notificacoesBellBadgeLabel');
        const bellList = document.getElementById('notificacoesBellList');
        const bell = document.getElementById('notificacoesBell');
        let loaded = false;

        function escapeHtml(text) {
            return String(text ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function renderAlertas(data) {
            const total = Number(data?.total || 0);
            const items = Array.isArray(data?.items) ? data.items : [];

            bellBadge.classList.toggle('d-none', total === 0);
            if (total > 0) {
                const badgeText = total > 99 ? '99+' : String(total);
                bellBadgeCount.textContent = badgeText;
                bellBadgeLabel.textContent = total === 1
                    ? '1 notificação pendente'
                    : `${total} notificações pendentes`;
            } else {
                bellBadgeCount.textContent = '';
                bellBadgeLabel.textContent = 'Sem notificações pendentes';
            }

            if (!items.length) {
                bellList.innerHTML = '<div class="px-3 py-2 text-muted small">Sem notificações no momento.</div>';
                return;
            }

            bellList.innerHTML = items.map(function(item) {
                const titulo = escapeHtml(item.titulo || 'Notificação');
                const descricao = escapeHtml(item.descricao || '');
                const data = escapeHtml(item.data || '');
                const hora = item.hora ? escapeHtml(String(item.hora).slice(0, 5)) : '';
                const dataHora = [data, hora].filter(Boolean).join(' ');
                const icone = escapeHtml(item.icone || 'fa-regular fa-bell');
                const url = escapeHtml(item.url || '#');

                return `
                    <a href="${url}" class="dropdown-item py-2 px-3 border-bottom">
                        <div class="d-flex align-items-start gap-2">
                            <i class="${icone} text-primary mt-1"></i>
                            <div class="small">
                                <div class="fw-semibold text-dark">${titulo}</div>
                                <div class="text-muted">${descricao}</div>
                                <div class="text-muted mt-1" style="font-size: 11px;">${dataHora}</div>
                            </div>
                        </div>
                    </a>
                `;
            }).join('');
        }

        function loadAlertas() {
            if (!bellList) {
                return;
            }

            if (!loaded) {
                bellList.innerHTML = '<div class="px-3 py-2 text-muted small">Carregando...</div>';
            }

            fetch('{{ route('notificacoes.alertas') }}', {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('Falha ao carregar notificações.');
                    }
                    return response.json();
                })
                .then(function(data) {
                    renderAlertas(data);
                    loaded = true;
                })
                .catch(function() {
                    bellList.innerHTML =
                        '<div class="px-3 py-2 text-danger small">Não foi possível carregar as notificações.</div>';
                });
        }

        loadAlertas();

        if (bell) {
            bell.addEventListener('click', function() {
                loadAlertas();
            });
        }
    });
</script>
