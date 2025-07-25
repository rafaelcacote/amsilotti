<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManagePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar permissão para gerenciar permissões
        $permission = Permission::firstOrCreate(['name' => 'manage permissions']);

        // Dar a permissão apenas para o administrador
        $adminRole = Role::where('name', 'administrador')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        echo "Permissão 'manage permissions' criada e atribuída ao administrador!\n";
    }
}
