<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TarefasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissões para o módulo de Tarefas
        $permissions = [
            'view tarefas',
            'create tarefas',
            'edit tarefas',
            'delete tarefas',
            'update status tarefas',
            'update situacao tarefas',
            'duplicate tarefas',
            'export tarefas',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Dar todas as permissões de tarefas para o role administrador
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Dar permissões básicas para o role operador
        $operadorRole = Role::where('name', 'operador')->first();
        if ($operadorRole) {
            $operadorRole->givePermissionTo([
                'view tarefas',
                'create tarefas',
                'edit tarefas',
                'update status tarefas',
                'update situacao tarefas',
            ]);
        }

        echo "Permissões de Tarefas criadas com sucesso!\n";
        echo "- view tarefas (Visualizar tarefas)\n";
        echo "- create tarefas (Criar tarefas)\n";
        echo "- edit tarefas (Editar tarefas)\n";
        echo "- delete tarefas (Excluir tarefas)\n";
        echo "- update status tarefas (Atualizar status de tarefas)\n";
        echo "- update situacao tarefas (Atualizar situação de tarefas)\n";
        echo "- duplicate tarefas (Duplicar tarefas)\n";
        echo "- export tarefas (Exportar/Imprimir tarefas)\n";
    }
}
