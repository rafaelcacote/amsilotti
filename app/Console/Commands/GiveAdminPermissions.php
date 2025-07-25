<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class GiveAdminPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:give-admin {email : O email do usuário}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dar permissões de administrador total para um usuário';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Buscar o usuário
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Usuário com email '{$email}' não encontrado!");
            return 1;
        }
        
        // Verificar se a role administrador existe
        $adminRole = Role::where('name', 'administrador')->first();
        
        if (!$adminRole) {
            $this->error("Role 'administrador' não encontrada! Execute o seeder primeiro: php artisan db:seed --class=RoleAndPermissionSeeder");
            return 1;
        }
        
        // Dar role de administrador
        $user->assignRole('administrador');
        
        $this->info("✅ Usuário '{$user->name}' ({$user->email}) agora tem permissões de ADMINISTRADOR TOTAL!");
        $this->info("🔑 Permissões atribuídas: " . $adminRole->permissions->count() . " permissões");
        
        // Listar algumas permissões principais
        $this->info("📋 Principais permissões:");
        $this->line("   - Gerenciar usuários (view, create, edit, delete users)");
        $this->line("   - Gerenciar configurações (manage settings)");
        $this->line("   - Gerenciar sistema (manage system)");
        $this->line("   - Todas as permissões de clientes, imóveis, vistorias, etc.");
        
        $this->info("\n🌟 Agora você pode acessar:");
        $this->line("   - /users (Gestão de Usuários)");
        $this->line("   - /roles (Gestão de Perfis)");
        $this->line("   - /permissions (Gestão de Permissões)");
        $this->line("   - /user-permissions (Usuários & Permissões)");
        
        return 0;
    }
}
