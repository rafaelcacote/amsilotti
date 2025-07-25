<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\PermissionHelper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Exibir página de gestão de permissões
     */
    public function index()
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('permissions.index', compact('users', 'roles', 'permissions'));
    }

    /**
     * Atribuir role a usuário
     */
    public function assignRole(Request $request)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        
        if (PermissionHelper::assignRole($user, $request->role)) {
            return response()->json(['success' => true, 'message' => 'Role atribuída com sucesso!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Erro ao atribuir role.']);
    }

    /**
     * Remover role de usuário
     */
    public function removeRole(Request $request)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        
        if (PermissionHelper::removeRole($user, $request->role)) {
            return response()->json(['success' => true, 'message' => 'Role removida com sucesso!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Erro ao remover role.']);
    }

    /**
     * Atribuir permission diretamente a usuário
     */
    public function givePermission(Request $request)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $user = User::findOrFail($request->user_id);
        
        if (PermissionHelper::givePermission($user, $request->permission)) {
            return response()->json(['success' => true, 'message' => 'Permissão atribuída com sucesso!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Erro ao atribuir permissão.']);
    }

    /**
     * Remover permission de usuário
     */
    public function revokePermission(Request $request)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $user = User::findOrFail($request->user_id);
        
        if (PermissionHelper::revokePermission($user, $request->permission)) {
            return response()->json(['success' => true, 'message' => 'Permissão removida com sucesso!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Erro ao remover permissão.']);
    }

    /**
     * Sincronizar roles de um usuário
     */
    public function syncRoles(Request $request)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        
        if (PermissionHelper::syncRoles($user, $request->roles ?? [])) {
            return response()->json(['success' => true, 'message' => 'Roles sincronizadas com sucesso!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Erro ao sincronizar roles.']);
    }

    /**
     * Obter dados de um usuário (AJAX)
     */
    public function getUserData($userId)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar permissões.');
        }
        
        $user = User::with('roles', 'permissions')->findOrFail($userId);
        
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    /**
     * Verificar permissões de usuário (para AJAX)
     */
    public function checkUserPermissions(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permissions' => 'required|array',
        ]);

        $user = User::findOrFail($request->user_id);
        $results = [];

        foreach ($request->permissions as $permission) {
            $results[$permission] = PermissionHelper::hasPermission($user, $permission);
        }

        return response()->json($results);
    }
}
