<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Helpers\PermissionHelper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ManagePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:manage 
                            {action : Ação a ser executada (assign-role, remove-role, create-role, create-permission, list-users, list-roles, list-permissions, list-grouped)}
                            {--user= : ID ou email do usuário}
                            {--role= : Nome da role}
                            {--permission= : Nome da permissão}
                            {--permissions=* : Lista de permissões (separadas por vírgula)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerenciar roles e permissões do sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'assign-role':
                return $this->assignRole();
                
            case 'remove-role':
                return $this->removeRole();
                
            case 'create-role':
                return $this->createRole();
                
            case 'create-permission':
                return $this->createPermission();
                
            case 'list-users':
                return $this->listUsers();
                
            case 'list-roles':
                return $this->listRoles();
                
            case 'list-permissions':
                return $this->listPermissions();
                
            case 'list-grouped':
                return $this->listGroupedPermissions();
                
            default:
                $this->error('Ação inválida. Use: assign-role, remove-role, create-role, create-permission, list-users, list-roles, list-permissions, ou list-grouped');
                return 1;
        }
    }

    /**
     * Atribuir role a usuário
     */
    private function assignRole()
    {
        $user = $this->getUser();
        $role = $this->option('role');

        if (!$user || !$role) {
            $this->error('É necessário fornecer --user e --role');
            return 1;
        }

        if (PermissionHelper::assignRole($user, $role)) {
            $this->info("Role '{$role}' atribuída ao usuário {$user->name} com sucesso!");
            return 0;
        }

        $this->error('Erro ao atribuir role');
        return 1;
    }

    /**
     * Remover role de usuário
     */
    private function removeRole()
    {
        $user = $this->getUser();
        $role = $this->option('role');

        if (!$user || !$role) {
            $this->error('É necessário fornecer --user e --role');
            return 1;
        }

        if (PermissionHelper::removeRole($user, $role)) {
            $this->info("Role '{$role}' removida do usuário {$user->name} com sucesso!");
            return 0;
        }

        $this->error('Erro ao remover role');
        return 1;
    }

    /**
     * Criar nova role
     */
    private function createRole()
    {
        $roleName = $this->option('role');
        $permissions = $this->option('permissions');

        if (!$roleName) {
            $this->error('É necessário fornecer --role');
            return 1;
        }

        $role = PermissionHelper::createRole($roleName, $permissions);

        if ($role) {
            $this->info("Role '{$roleName}' criada com sucesso!");
            if (!empty($permissions)) {
                $this->info("Permissões atribuídas: " . implode(', ', $permissions));
            }
            return 0;
        }

        $this->error('Erro ao criar role');
        return 1;
    }

    /**
     * Criar nova permission
     */
    private function createPermission()
    {
        $permissionName = $this->option('permission');

        if (!$permissionName) {
            $this->error('É necessário fornecer --permission');
            return 1;
        }

        $permission = PermissionHelper::createPermission($permissionName);

        if ($permission) {
            $this->info("Permissão '{$permissionName}' criada com sucesso!");
            return 0;
        }

        $this->error('Erro ao criar permissão');
        return 1;
    }

    /**
     * Listar usuários com suas roles
     */
    private function listUsers()
    {
        $users = User::with('roles')->get();

        $this->info('=== USUÁRIOS E SUAS ROLES ===');
        
        foreach ($users as $user) {
            $roles = $user->getRoleNames()->implode(', ');
            $this->line("ID: {$user->id} | Nome: {$user->name} | Email: {$user->email} | Roles: {$roles}");
        }

        return 0;
    }

    /**
     * Listar todas as roles
     */
    private function listRoles()
    {
        $roles = Role::with('permissions')->get();

        $this->info('=== ROLES E SUAS PERMISSÕES ===');
        
        foreach ($roles as $role) {
            $permissions = $role->permissions->pluck('name')->implode(', ');
            $this->line("Role: {$role->name} | Permissões: {$permissions}");
        }

        return 0;
    }

    /**
     * Listar todas as permissions
     */
    private function listPermissions()
    {
        $permissions = Permission::all();

        $this->info('=== PERMISSÕES DISPONÍVEIS ===');
        
        foreach ($permissions as $permission) {
            $this->line("- {$permission->name}");
        }

        return 0;
    }

    /**
     * Obter usuário por ID ou email
     */
    private function getUser()
    {
        $userIdentifier = $this->option('user');

        if (!$userIdentifier) {
            return null;
        }

        // Tentar por ID primeiro
        if (is_numeric($userIdentifier)) {
            return User::find($userIdentifier);
        }

        // Senão, tentar por email
        return User::where('email', $userIdentifier)->first();
    }

    /**
     * Listar permissões agrupadas
     */
    private function listGroupedPermissions()
    {
        $this->info('=== PERMISSÕES AGRUPADAS ===');
        
        $permissions = Permission::all()->groupBy(function($permission) {
            // Se a permissão contém 'tarefas', agrupa como 'tarefas'
            if (str_contains($permission->name, 'tarefas')) {
                return 'tarefas';
            }
            // Caso contrário, usa a segunda palavra como antes
            return explode(' ', $permission->name)[1] ?? 'Outros';
        });

        foreach ($permissions as $group => $groupPermissions) {
            $this->line("\n📂 Grupo: " . ucfirst($group) . " ({$groupPermissions->count()} permissões)");
            foreach ($groupPermissions as $permission) {
                $this->line("  - {$permission->name}");
            }
        }

        $this->info("\n=== PERMISSÕES POR ROLE ===");
        $roles = Role::with('permissions')->get();
        
        foreach ($roles as $role) {
            $tarefasPermissions = $role->permissions->filter(function($permission) {
                return str_contains($permission->name, 'tarefas');
            });
            
            $this->line("\n👤 Role: " . ucfirst($role->name) . " (Total: {$role->permissions->count()})");
            
            if ($tarefasPermissions->count() > 0) {
                $this->line("  📋 Permissões de Tarefas:");
                foreach ($tarefasPermissions as $permission) {
                    $this->line("    - {$permission->name}");
                }
            }
            
            $otherPermissions = $role->permissions->filter(function($permission) {
                return !str_contains($permission->name, 'tarefas');
            });
            
            if ($otherPermissions->count() > 0) {
                $this->line("  🔧 Outras Permissões:");
                foreach ($otherPermissions as $permission) {
                    $this->line("    - {$permission->name}");
                }
            }
            
            if ($role->permissions->count() == 0) {
                $this->line("  (sem permissões)");
            }
        }
    }
}
