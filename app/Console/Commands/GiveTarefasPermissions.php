<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class GiveTarefasPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:give-tarefas-permissions {email : O email do usuário}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dar todas as permissões de tarefas para um usuário';

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
        
        // Dar permissões diretas de tarefas
        $tarefasPermissions = [
            'view tarefas',
            'create tarefas',
            'edit tarefas',
            'delete tarefas',
            'update status tarefas',
            'update situacao tarefas',
            'duplicate tarefas',
            'export tarefas',
        ];
        
        foreach ($tarefasPermissions as $permission) {
            $user->givePermissionTo($permission);
        }
        
        $this->info("✅ Usuário '{$user->name}' ({$user->email}) agora tem todas as permissões de TAREFAS!");
        $this->info("🔑 Permissões atribuídas:");
        
        foreach ($tarefasPermissions as $permission) {
            $this->line("   - {$permission}");
        }
        
        $this->info("\n🌟 Agora você pode acessar:");
        $this->line("   - Visualizar tarefas");
        $this->line("   - Criar novas tarefas");
        $this->line("   - Editar tarefas existentes");
        $this->line("   - Excluir tarefas");
        $this->line("   - Atualizar status e situação");
        $this->line("   - Duplicar tarefas");
        $this->line("   - Exportar/Imprimir relatórios");
        
        return 0;
    }
}
