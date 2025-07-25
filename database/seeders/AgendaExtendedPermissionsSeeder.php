<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AgendaExtendedPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissões adicionais para o módulo de Agenda (incluindo tipos de evento)
        $permissions = [
            'view agenda tipos-evento',
            'create agenda tipos-evento',
            'edit agenda tipos-evento', 
            'delete agenda tipos-evento',
            'print agenda',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Dar todas as permissões de agenda estendidas para o role administrador
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Dar permissões básicas para o role supervisor
        $supervisorRole = Role::where('name', 'supervisor')->first();
        if ($supervisorRole) {
            $supervisorRole->givePermissionTo([
                'view agenda tipos-evento',
                'create agenda tipos-evento',
                'edit agenda tipos-evento',
                'print agenda',
            ]);
        }

        // Dar apenas permissão de visualização para o role tecnico
        $tecnicoRole = Role::where('name', 'tecnico')->first();
        if ($tecnicoRole) {
            $tecnicoRole->givePermissionTo([
                'view agenda tipos-evento',
                'print agenda',
            ]);
        }

        echo "Permissões estendidas de Agenda (incluindo tipos de evento) criadas com sucesso!\n";
    }
}
