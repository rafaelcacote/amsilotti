<?php

namespace App\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionHelper
{
    /**
     * Atribuir role a um usuário
     */
    public static function assignRole(User $user, string $role): bool
    {
        try {
            $user->assignRole($role);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remover role de um usuário
     */
    public static function removeRole(User $user, string $role): bool
    {
        try {
            $user->removeRole($role);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Atribuir permission diretamente a um usuário
     */
    public static function givePermission(User $user, string $permission): bool
    {
        try {
            $user->givePermissionTo($permission);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Remover permission de um usuário
     */
    public static function revokePermission(User $user, string $permission): bool
    {
        try {
            $user->revokePermissionTo($permission);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Verificar se usuário tem role
     */
    public static function hasRole(User $user, string $role): bool
    {
        return $user->hasRole($role);
    }

    /**
     * Verificar se usuário tem permission
     */
    public static function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermissionTo($permission);
    }

    /**
     * Verificar se usuário tem qualquer uma das roles
     */
    public static function hasAnyRole(User $user, array $roles): bool
    {
        return $user->hasAnyRole($roles);
    }

    /**
     * Verificar se usuário tem todas as roles
     */
    public static function hasAllRoles(User $user, array $roles): bool
    {
        return $user->hasAllRoles($roles);
    }

    /**
     * Obter todas as permissions de um usuário
     */
    public static function getUserPermissions(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return $user->getAllPermissions();
    }

    /**
     * Obter todas as roles de um usuário
     */
    public static function getRoles(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return $user->getRoleNames();
    }

    /**
     * Sincronizar roles (remove todas e adiciona as especificadas)
     */
    public static function syncRoles(User $user, array $roles): bool
    {
        try {
            $user->syncRoles($roles);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Sincronizar permissions (remove todas e adiciona as especificadas)
     */
    public static function syncPermissions(User $user, array $permissions): bool
    {
        try {
            $user->syncPermissions($permissions);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Criar nova role
     */
    public static function createRole(string $name, array $permissions = []): ?Role
    {
        try {
            $role = Role::create(['name' => $name]);
            
            if (!empty($permissions)) {
                $role->givePermissionTo($permissions);
            }
            
            return $role;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Criar nova permission
     */
    public static function createPermission(string $name): ?Permission
    {
        try {
            return Permission::create(['name' => $name]);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Obter todas as roles disponíveis
     */
    public static function getAllRoles(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    /**
     * Obter todas as permissions disponíveis
     */
    public static function getAllPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::all();
    }
}
