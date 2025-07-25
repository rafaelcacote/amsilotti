<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PericiasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissões para o módulo de Perícias
        $permissions = [
            'view pericias',
            'create pericias',
            'edit pericias',
            'delete pericias',
            'export pericias',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Dar todas as permissões de perícias para o role administrador
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Dar permissões básicas para o role supervisor
        $supervisorRole = Role::where('name', 'supervisor')->first();
        if ($supervisorRole) {
            $supervisorRole->givePermissionTo([
                'view pericias',
                'create pericias',
                'edit pericias',
                'delete pericias',
                'export pericias',
            ]);
        }

        // Dar permissões básicas para o role tecnico
        $tecnicoRole = Role::where('name', 'tecnico')->first();
        if ($tecnicoRole) {
            $tecnicoRole->givePermissionTo([
                'view pericias',
                'create pericias',
                'edit pericias',
            ]);
        }

        echo "Permissões de Perícias criadas com sucesso!\n";
        echo "- view pericias (Visualizar perícias)\n";
        echo "- create pericias (Criar perícias)\n";
        echo "- edit pericias (Editar perícias)\n";
        echo "- delete pericias (Excluir perícias)\n";
        echo "- export pericias (Exportar/Imprimir perícias)\n";
    }
}
