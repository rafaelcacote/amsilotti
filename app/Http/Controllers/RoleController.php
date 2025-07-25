<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para gerenciar perfis.');
        }
        
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para criar perfis.');
        }
        
        $permissions = Permission::all()->groupBy(function($permission) {
            // Se a permissão contém 'tarefas', agrupa como 'tarefas'
            if (str_contains($permission->name, 'tarefas')) {
                return 'tarefas';
            }
            // Caso contrário, usa a segunda palavra como antes
            return explode(' ', $permission->name)[1] ?? 'Outros';
        });
        
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para criar perfis.');
        }
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('roles.index')
                        ->with('success', 'Perfil criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para visualizar perfis.');
        }
        
        $role->load('permissions', 'users');
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para editar perfis.');
        }
        
        $permissions = Permission::all()->groupBy(function($permission) {
            // Se a permissão contém 'tarefas', agrupa como 'tarefas'
            if (str_contains($permission->name, 'tarefas')) {
                return 'tarefas';
            }
            // Caso contrário, usa a segunda palavra como antes
            return explode(' ', $permission->name)[1] ?? 'Outros';
        });
        
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para atualizar perfis.');
        }
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->update(['name' => $request->name]);
        
        // Sincronizar permissões
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')
                        ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!auth()->user()->can('manage settings')) {
            abort(403, 'Você não tem permissão para excluir perfis.');
        }
        
        // Verificar se existem usuários com este role
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                            ->with('error', 'Não é possível excluir um perfil que possui usuários vinculados.');
        }

        $role->delete();

        return redirect()->route('roles.index')
                        ->with('success', 'Perfil excluído com sucesso!');
    }
}
