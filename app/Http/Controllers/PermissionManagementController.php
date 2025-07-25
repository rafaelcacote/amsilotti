<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Exibir lista de permissões agrupadas
     */
    public function index()
    {
        $this->authorize('manage permissions');
        
        $permissions = Permission::all();
        $roles = Role::with('permissions')->get();
        
        // Agrupar permissões por módulo
        $groupedPermissions = $this->groupPermissions($permissions);
        
        return view('admin.permissions.index', compact('groupedPermissions', 'roles', 'permissions'));
    }

    /**
     * Formulário para criar nova permissão
     */
    public function create()
    {
        $this->authorize('manage permissions');
        
        // Obter grupos existentes
        $existingGroups = $this->getExistingGroups();
        
        return view('admin.permissions.create', compact('existingGroups'));
    }

    /**
     * Salvar nova permissão
     */
    public function store(Request $request)
    {
        $this->authorize('manage permissions');
        
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'group' => 'required|string',
            'description' => 'nullable|string|max:255',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permissão criada com sucesso!');
    }

    /**
     * Atribuir permissões a roles
     */
    public function assignToRole(Request $request)
    {
        $this->authorize('manage permissions');
        
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($validated['role_id']);
        
        // Sincronizar permissões
        $permissions = Permission::whereIn('id', $validated['permissions'] ?? [])->get();
        $role->syncPermissions($permissions);

        return redirect()->route('admin.permissions.index')
            ->with('success', "Permissões do role '{$role->name}' atualizadas com sucesso!");
    }

    /**
     * Excluir permissão
     */
    public function destroy(Permission $permission)
    {
        $this->authorize('manage permissions');
        
        $permissionName = $permission->name;
        
        // Verificar se a permissão está sendo usada
        if ($permission->roles()->count() > 0) {
            $roles = $permission->roles()->pluck('name')->toArray();
            $rolesList = implode(', ', $roles);
            
            return redirect()->route('admin.permissions.index')
                ->with('error', "Não é possível excluir a permissão '{$permissionName}' pois está atribuída aos roles: {$rolesList}");
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', "Permissão '{$permissionName}' excluída com sucesso!");
    }

    /**
     * Criar permissões em lote para um novo módulo
     */
    public function createModule(Request $request)
    {
        $this->authorize('manage permissions');
        
        $validated = $request->validate([
            'module_name' => 'required|string|max:50',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|string|in:view,create,edit,delete,export,print',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $moduleName = strtolower($validated['module_name']);
        $createdPermissions = [];

        // Criar permissões para o módulo
        foreach ($validated['permissions'] as $action) {
            $permissionName = $action . ' ' . $moduleName;
            
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
            
            $createdPermissions[] = $permission;
        }

        // Atribuir permissões aos roles selecionados
        if (!empty($validated['roles'])) {
            $roles = Role::whereIn('id', $validated['roles'])->get();
            
            foreach ($roles as $role) {
                foreach ($createdPermissions as $permission) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', "Módulo '{$moduleName}' criado com " . count($createdPermissions) . " permissões!");
    }

    /**
     * Agrupar permissões por módulo
     */
    private function groupPermissions($permissions)
    {
        $grouped = [];
        
        foreach ($permissions as $permission) {
            $parts = explode(' ', $permission->name);
            $action = $parts[0];
            $module = implode(' ', array_slice($parts, 1));
            
            // Normalizar nome do grupo
            $groupName = ucfirst(str_replace(['-', '_'], ' ', $module));
            
            if (!isset($grouped[$groupName])) {
                $grouped[$groupName] = [];
            }
            
            $grouped[$groupName][] = $permission;
        }
        
        // Ordenar grupos
        ksort($grouped);
        
        return $grouped;
    }

    /**
     * Obter grupos existentes
     */
    private function getExistingGroups()
    {
        $permissions = Permission::all();
        $groups = [];
        
        foreach ($permissions as $permission) {
            $parts = explode(' ', $permission->name);
            $module = implode(' ', array_slice($parts, 1));
            $groups[] = $module;
        }
        
        return array_unique($groups);
    }

    /**
     * API para buscar permissões por grupo
     */
    public function getByGroup(Request $request)
    {
        $group = $request->get('group');
        $permissions = Permission::where('name', 'like', "%{$group}%")->get();
        
        return response()->json($permissions);
    }
}
