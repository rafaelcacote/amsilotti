<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Criar permissions
        $permissions = [
            // Gestão de usuários
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Gestão de clientes
            'view clientes',
            'create clientes',
            'edit clientes',
            'delete clientes',

            // Gestão de imóveis
            'view imoveis',
            'create imoveis',
            'edit imoveis',
            'delete imoveis',

            // Gestão de vistorias
            'view vistorias',
            'create vistorias',
            'edit vistorias',
            'delete vistorias',

            // Gestão de ordens de serviço
            'view ordens-servico',
            'create ordens-servico',
            'edit ordens-servico',
            'delete ordens-servico',

            // Gestão de agenda
            'view agenda',
            'create agenda',
            'edit agenda',
            'delete agenda',

            // Relatórios
            'view relatorios',
            'export relatorios',

            // Configurações do sistema
            'manage settings',
            'manage system',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Criar roles
        $adminRole = Role::create(['name' => 'administrador']);
        $tecnicoRole = Role::create(['name' => 'tecnico']);
        $supervisorRole = Role::create(['name' => 'supervisor']);
        $clienteAmostraRole = Role::create(['name' => 'cliente_amostra']);

        // Atribuir permissions aos roles
        // Administrador tem todas as permissões
        $adminRole->givePermissionTo(Permission::all());

        // Supervisor tem quase todas, exceto algumas de sistema
        $supervisorRole->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view clientes', 'create clientes', 'edit clientes', 'delete clientes',
            'view imoveis', 'create imoveis', 'edit imoveis', 'delete imoveis',
            'view vistorias', 'create vistorias', 'edit vistorias', 'delete vistorias',
            'view ordens-servico', 'create ordens-servico', 'edit ordens-servico', 'delete ordens-servico',
            'view agenda', 'create agenda', 'edit agenda', 'delete agenda',
            'view relatorios', 'export relatorios',
        ]);

        // Técnico tem permissões operacionais
        $tecnicoRole->givePermissionTo([
            'view clientes', 'edit clientes',
            'view imoveis', 'edit imoveis',
            'view vistorias', 'create vistorias', 'edit vistorias',
            'view ordens-servico', 'edit ordens-servico',
            'view agenda', 'create agenda', 'edit agenda',
            'view relatorios',
        ]);

        // Cliente Amostra só pode ver consultas de imóveis
        $clienteAmostraRole->givePermissionTo([
            'view imoveis',
        ]);

        // Criar usuário administrador padrão se não existir
        $adminUser = User::where('email', 'admin@sistema.com')->first();
        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'Administrador do Sistema',
                'email' => 'admin@sistema.com',
                'password' => bcrypt('admin123'),
            ]);
        }
        
        $adminUser->assignRole('administrador');
    }
}
