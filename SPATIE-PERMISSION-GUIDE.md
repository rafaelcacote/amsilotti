# Spatie Laravel Permission - Guia de Uso

## Instalação e Configuração ✅

O Spatie Laravel Permission foi instalado e configurado com sucesso no projeto. As migrations não foram executadas conforme solicitado, pois as tabelas já existem.

## Roles e Permissions Criadas

### Roles Disponíveis:
- **administrador**: Acesso total ao sistema
- **supervisor**: Gestão operacional e relatórios
- **tecnico**: Operações de campo e atualizações
- **visualizador**: Apenas visualização

### Permissions Criadas:

#### Gestão de Usuários
- view users
- create users  
- edit users
- delete users

#### Gestão de Clientes
- view clientes
- create clientes
- edit clientes
- delete clientes

#### Gestão de Imóveis
- view imoveis
- create imoveis
- edit imoveis
- delete imoveis

#### Gestão de Vistorias
- view vistorias
- create vistorias
- edit vistorias
- delete vistorias

#### Gestão de Ordens de Serviço
- view ordens-servico
- create ordens-servico
- edit ordens-servico
- delete ordens-servico

#### Gestão de Agenda
- view agenda
- create agenda
- edit agenda
- delete agenda

#### Relatórios
- view relatorios
- export relatorios

#### Configurações do Sistema
- manage settings
- manage system

## Como Usar

### 1. Em Controllers

```php
// Verificar permissão
$this->authorize('view clientes');

// Verificar role
if (auth()->user()->hasRole('administrador')) {
    // código para administrador
}

// Verificar múltiplas roles
if (auth()->user()->hasAnyRole(['administrador', 'supervisor'])) {
    // código
}

// Usando helper personalizado
use App\Helpers\PermissionHelper;

if (PermissionHelper::hasPermission($user, 'edit clientes')) {
    // código
}
```

### 2. Em Routes (Middleware)

```php
// Proteger rota com permission
Route::get('/clientes', [ClienteController::class, 'index'])
    ->middleware('permission:view clientes');

// Proteger rota com role
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('role:administrador');

// Proteger grupo de rotas
Route::middleware(['role:administrador'])->group(function () {
    Route::resource('users', UserController::class);
});
```

### 3. Em Views Blade

```blade
{{-- Verificar role --}}
@role('administrador')
    <p>Você é administrador</p>
@endrole

{{-- Verificar permission --}}
@can('create clientes')
    <a href="{{ route('clientes.create') }}">Novo Cliente</a>
@endcan

{{-- Verificar múltiplas roles --}}
@hasanyrole('administrador|supervisor')
    <div>Painel de gestão</div>
@endhasanyrole

{{-- Verificar se NÃO tem permissão --}}
@cannot('delete users')
    <p>Sem permissão para excluir</p>
@endcannot
```

### 4. Gerenciamento via Comando Artisan

```bash
# Listar usuários e roles
php artisan permission:manage list-users

# Listar todas as roles
php artisan permission:manage list-roles

# Listar todas as permissions
php artisan permission:manage list-permissions

# Atribuir role a usuário
php artisan permission:manage assign-role --user=1 --role=administrador
php artisan permission:manage assign-role --user=usuario@email.com --role=tecnico

# Remover role de usuário
php artisan permission:manage remove-role --user=1 --role=tecnico

# Criar nova role
php artisan permission:manage create-role --role="nova-role" --permissions="permission1,permission2"

# Criar nova permission
php artisan permission:manage create-permission --permission="nova-permissao"
```

### 5. Gerenciamento Programático

```php
use App\Helpers\PermissionHelper;
use App\Models\User;

$user = User::find(1);

// Atribuir role
PermissionHelper::assignRole($user, 'tecnico');

// Remover role  
PermissionHelper::removeRole($user, 'tecnico');

// Atribuir permission diretamente
PermissionHelper::givePermission($user, 'view clientes');

// Remover permission
PermissionHelper::revokePermission($user, 'view clientes');

// Sincronizar roles (remove todas e adiciona as especificadas)
PermissionHelper::syncRoles($user, ['tecnico', 'visualizador']);

// Verificar permissions
if (PermissionHelper::hasPermission($user, 'edit clientes')) {
    // usuário pode editar clientes
}

// Verificar roles
if (PermissionHelper::hasRole($user, 'administrador')) {
    // usuário é administrador
}
```

### 6. Interface Web de Gestão

Acesse `/permissions` para gerenciar permissões via interface web (apenas usuários com permissão `manage settings`).

## Usuário Padrão Criado

- **Email**: admin@sistema.com
- **Senha**: admin123  
- **Role**: administrador

## Middlewares Disponíveis

- `role:nome-da-role` - Verificar role específica
- `permission:nome-da-permissao` - Verificar permissão específica  
- `role_or_permission:role1|permission1` - Verificar role OU permissão

## Exemplos Práticos

### Proteger Controller Completo
```php
class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view clientes')->only(['index', 'show']);
        $this->middleware('permission:create clientes')->only(['create', 'store']);
        $this->middleware('permission:edit clientes')->only(['edit', 'update']);
        $this->middleware('permission:delete clientes')->only(['destroy']);
    }
}
```

### Menu Condicional
```blade
<nav>
    @can('view clientes')
        <a href="{{ route('clientes.index') }}">Clientes</a>
    @endcan
    
    @role('administrador')
        <a href="{{ route('permissions.index') }}">Permissões</a>
    @endrole
</nav>
```

### Dashboard Baseado em Permissões
```php
public function dashboard()
{
    $data = [];
    
    if (auth()->user()->can('view clientes')) {
        $data['clientes'] = Cliente::count();
    }
    
    if (auth()->user()->hasRole('administrador')) {
        $data['system_stats'] = $this->getSystemStats();
    }
    
    return view('dashboard', compact('data'));
}
```

## Troubleshooting

### Cache de Permissões
Se as permissões não estiverem funcionando corretamente:

```bash
php artisan permission:cache-reset
```

### Verificar Configuração
Verifique o arquivo `config/permission.php` para configurações específicas.

### Logs
As operações de permissão são logadas. Verifique `storage/logs` em caso de problemas.

## Próximos Passos

1. Personalize as permissões conforme suas necessidades específicas
2. Implemente validações adicionais nos controllers
3. Crie interfaces de usuário específicas para cada role
4. Configure logs de auditoria para mudanças de permissões
5. Implemente testes automatizados para verificar as permissões

Este sistema está pronto para uso e pode ser estendido conforme necessário!
