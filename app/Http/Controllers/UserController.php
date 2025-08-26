<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller

{
    public function index(Request $request)
    {
        // Verificar permissão
        if (!auth()->user()->can('view users')) {
            abort(403, 'Você não tem permissão para visualizar usuários.');
        }

        // Pesquisa pelo nome, email e CPF do usuário
        $users = User::with('roles')
            ->when($request->name, function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->email, function ($query) use ($request) {
                return $query->where('email', 'like', '%' . $request->email . '%');
            })
            ->when($request->cpf, function ($query) use ($request) {
                return $query->where('cpf', 'like', '%' . $request->cpf . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Altere o número para a quantidade desejada por página

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->can('create users')) {
            abort(403, 'Você não tem permissão para criar usuários.');
        }

        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('create users')) {
            abort(403, 'Você não tem permissão para criar usuários.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'cpf' => 'nullable|digits:11|unique:users',
            'password' => 'required|string|min:6',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cpf' => $validated['cpf'],
            'password' => Hash::make($validated['password']),
            'status' => 'A',
        ]);

        // Atribuir roles se fornecidas
        if (!empty($validated['roles'])) {
            $user->assignRole($validated['roles']);
        }

        return redirect()->route('users.index')
                        ->with('success', 'Usuário criado com sucesso!');
    }

    public function show(User $user)
    {
        if (!auth()->user()->can('view users')) {
            abort(403, 'Você não tem permissão para visualizar usuários.');
        }

        $user->load('roles', 'permissions');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->can('edit users')) {
            abort(403, 'Você não tem permissão para editar usuários.');
        }

        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->can('edit users')) {
            abort(403, 'Você não tem permissão para editar usuários.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'cpf' => 'nullable|digits:11|unique:users,cpf,'.$user->id,
            'password' => 'nullable|string|min:6',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
            'status' => 'required|in:A,I',
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
            'status' => $data['status'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        // Sincronizar roles
        $user->syncRoles($data['roles'] ?? []);

        return redirect()->route('users.index')
                        ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->can('delete users')) {
            abort(403, 'Você não tem permissão para excluir usuários.');
        }

        $user->delete();
        return redirect()->route('users.index')
                        ->with('success', 'Usuário excluído com sucesso!');
    }
}
