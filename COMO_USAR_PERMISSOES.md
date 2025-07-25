# 🔐 Sistema de Gerenciamento de Permissões

## 📋 **Como Criar e Gerenciar Permissões**

### 🎯 **Acesso ao Sistema**
- **Menu**: Controle de Acesso → Gerenciar Permissões
- **Rota**: `/admin/permissions`
- **Permissão necessária**: `manage permissions` (apenas Administradores)

---

## 🛠️ **Criando Permissões**

### **Método 1: Criar Permissão Individual**
1. Clique em **"Nova Permissão"**
2. Preencha os campos:
   - **Nome**: Ex: `view financeiro`, `create fornecedores`
   - **Grupo**: Ex: `financeiro`, `fornecedores` 
   - **Descrição**: Opcional
3. Clique em **"Criar Permissão"**

### **Método 2: Criar Módulo Completo**
1. Clique em **"Criar Módulo"**
2. Preencha:
   - **Nome do Módulo**: Ex: `relatorios`, `configuracoes`
   - **Permissões**: Selecione as ações (view, create, edit, delete, export, print)
   - **Roles**: Escolha quais perfis receberão as permissões
3. Clique em **"Criar Módulo"**

---

## 📊 **Padrões de Nomenclatura**

### **Formato Padrão**
```
[ação] [módulo]
```

### **Ações Comuns**
- `view` - Visualizar/Listar
- `create` - Criar novos registros
- `edit` - Editar registros existentes
- `delete` - Excluir registros
- `export` - Exportar dados
- `print` - Imprimir relatórios

### **Exemplos**
```
view clientes
create clientes
edit clientes
delete clientes
export clientes

view financeiro
create fornecedores
edit configuracoes
delete backup
print relatorios
```

---

## 🎭 **Gerenciando Roles**

### **Atribuir Permissões a Roles**
1. Vá para a aba **"Permissões por Role"**
2. Localize o role desejado
3. Marque/desmarque as permissões
4. Clique em **"Salvar Permissões para [Role]"**

### **Distribuição por Role (Sugerida)**
- **👑 Administrador**: Todas as permissões
- **👨‍💼 Supervisor**: View, Create, Edit (sem Delete críticos)
- **👨‍💻 Técnico**: View, Create, Edit (limitado)
- **👁️ Visualizador**: Apenas View

---

## 🔧 **Implementando em Controllers**

### **Método 1: $this->authorize()**
```php
public function index()
{
    $this->authorize('view clientes');
    // ... resto do código
}

public function create()
{
    $this->authorize('create clientes');
    // ... resto do código
}
```

### **Método 2: Middleware**
```php
// Em routes/web.php
Route::middleware(['auth', 'permission:view clientes'])->group(function () {
    Route::get('/clientes', [ClienteController::class, 'index']);
});
```

---

## 🎨 **Protegendo Views**

### **Botões e Links**
```blade
@can('create clientes')
    <a href="{{ route('clientes.create') }}" class="btn btn-success">
        Novo Cliente
    </a>
@endcan

@can('edit clientes')
    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary">
        Editar
    </a>
@endcan

@can('delete clientes')
    <form method="POST" action="{{ route('clientes.destroy', $cliente) }}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
@endcan
```

### **Seções Inteiras**
```blade
@can('view financeiro')
    <div class="financial-section">
        <!-- Conteúdo financeiro -->
    </div>
@endcan
```

---

## 📁 **Organizando por Grupos**

### **Grupos Sugeridos**
- **Agenda**: `view agenda`, `create agenda`, `edit agenda`, `delete agenda`
- **Clientes**: `view clientes`, `create clientes`, `edit clientes`, `delete clientes`
- **Financeiro**: `view financeiro`, `edit financeiro`, `export financeiro`
- **Configurações**: `view configuracoes`, `edit configuracoes`
- **Sistema**: `manage system`, `manage permissions`, `view logs`

---

## 🚀 **Exemplo Prático: Novo Módulo "Fornecedores"**

### **1. Criar o Módulo**
```
Módulo: fornecedores
Permissões: view, create, edit, delete, export
Roles: Administrador (todas), Supervisor (view, create, edit)
```

### **2. No Controller**
```php
class FornecedorController extends Controller
{
    public function index()
    {
        $this->authorize('view fornecedores');
        // ...
    }
    
    public function create()
    {
        $this->authorize('create fornecedores');
        // ...
    }
}
```

### **3. Na View**
```blade
@can('view fornecedores')
    <!-- Lista de fornecedores -->
@endcan

@can('create fornecedores')
    <a href="{{ route('fornecedores.create') }}">Novo Fornecedor</a>
@endcan
```

### **4. No Menu**
```blade
@can('view fornecedores')
<li class="nav-item">
    <a class="nav-link" href="{{ route('fornecedores.index') }}">
        <i class="fa fa-truck nav-icon"></i> Fornecedores
    </a>
</li>
@endcan
```

---

## ⚠️ **Dicas Importantes**

1. **Consistência**: Use sempre o mesmo padrão de nomenclatura
2. **Granularidade**: Crie permissões específicas quando necessário
3. **Testagem**: Sempre teste as permissões com diferentes roles
4. **Documentação**: Mantenha registro das permissões criadas
5. **Backup**: Antes de alterar permissões em produção, faça backup

---

## 🔍 **Verificando Permissões via Terminal**

```bash
# Listar permissões agrupadas
php artisan permission:manage list-grouped

# Verificar permissões de um usuário
php artisan permission:manage user-permissions [email]
```

---

🎉 **Pronto!** Agora você pode criar e gerenciar permissões de forma dinâmica e organizada!
