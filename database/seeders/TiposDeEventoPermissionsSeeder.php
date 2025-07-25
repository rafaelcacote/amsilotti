<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TiposDeEventoPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissões para o módulo de Tipos de Evento
        $permissions = [
            'view tipos-de-evento',
            'create tipos-de-evento',
            'edit tipos-de-evento',
            'delete tipos-de-evento',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Dar todas as permissões de tipos de evento para o role administrador
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Dar permissões básicas para o role supervisor
        $supervisorRole = Role::where('name', 'supervisor')->first();
        if ($supervisorRole) {
            $supervisorRole->givePermissionTo([
                'view tipos-de-evento',
                'create tipos-de-evento',
                'edit tipos-de-evento',
            ]);
        }

        // Dar apenas permissão de visualização para o role tecnico
        $tecnicoRole = Role::where('name', 'tecnico')->first();
        if ($tecnicoRole) {
            $tecnicoRole->givePermissionTo([
                'view tipos-de-evento',
            ]);
        }

        echo "Permissões de Tipos de Evento criadas com sucesso!\n";
    }
}
