<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
use App\Helpers\PermissionHelper;

/**
 * Exemplos de como usar permissões em controllers
 */
class ExampleController extends Controller
{
    /**
     * Exemplo 1: Verificar permissão no método
     */
    public function index()
    {
        // Verificar se o usuário pode ver clientes
        $this->authorize('view clientes');
        
        // ou usar o helper
        if (!PermissionHelper::hasPermission(auth()->user(), 'view clientes')) {
            abort(403, 'Você não tem permissão para ver clientes.');
        }
        
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Exemplo 2: Verificar role específica
     */
    public function create()
    {
        // Apenas administradores e supervisores podem criar
        if (!auth()->user()->hasAnyRole(['administrador', 'supervisor'])) {
            abort(403, 'Acesso negado.');
        }
        
        return view('clientes.create');
    }

    /**
     * Exemplo 3: Usar middleware diretamente no constructor
     */
    public function __construct()
    {
        // Aplicar middleware a todos os métodos
        $this->middleware('permission:view clientes')->only(['index', 'show']);
        $this->middleware('permission:create clientes')->only(['create', 'store']);
        $this->middleware('permission:edit clientes')->only(['edit', 'update']);
        $this->middleware('permission:delete clientes')->only(['destroy']);
        
        // Aplicar middleware de role
        $this->middleware('role:administrador')->only(['adminPanel']);
    }

    /**
     * Exemplo 4: Verificar permissão condicional
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        // Técnicos só podem ver clientes que estão atribuídos a eles
        if (auth()->user()->hasRole('tecnico')) {
            // Verificar se o cliente está atribuído ao técnico
            $membroEquipe = auth()->user()->membroEquipe;
            if (!$membroEquipe || $cliente->tecnico_responsavel_id !== $membroEquipe->id) {
                abort(403, 'Você só pode ver clientes atribuídos a você.');
            }
        }
        
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Exemplo 5: Diferentes permissões para diferentes ações
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        
        // Verificar permissão básica
        $this->authorize('edit clientes');
        
        // Verificações adicionais baseadas em campos específicos
        if ($request->has('status') && $request->status === 'arquivado') {
            // Apenas supervisores podem arquivar
            if (!auth()->user()->hasRole('supervisor')) {
                abort(403, 'Apenas supervisores podem arquivar clientes.');
            }
        }
        
        $cliente->update($request->validated());
        
        return redirect()->route('clientes.index')
                        ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Exemplo 6: Middleware no método
     */
    public function adminPanel()
    {
        // Verificar se é administrador
        $this->middleware('role:administrador');
        
        // Ou verificar permissão específica
        $this->authorize('manage system');
        
        $stats = [
            'total_users' => User::count(),
            'total_roles' => \Spatie\Permission\Models\Role::count(),
            'total_permissions' => \Spatie\Permission\Models\Permission::count(),
        ];
        
        return view('admin.panel', compact('stats'));
    }

    /**
     * Exemplo 7: Retornar dados diferentes baseado em permissões
     */
    public function getClientes()
    {
        $user = auth()->user();
        
        if ($user->hasRole('administrador')) {
            // Administrador vê todos os clientes
            $clientes = Cliente::with('vistorias', 'imoveis')->get();
            
        } elseif ($user->hasRole('supervisor')) {
            // Supervisor vê clientes da sua região/equipe
            $clientes = Cliente::where('regiao_id', $user->regiao_id)
                             ->with('vistorias', 'imoveis')
                             ->get();
                             
        } elseif ($user->hasRole('tecnico')) {
            // Técnico vê apenas seus clientes
            $membroEquipe = $user->membroEquipe;
            $clientes = Cliente::where('tecnico_responsavel_id', $membroEquipe->id)
                             ->with('vistorias')
                             ->get();
                             
        } else {
            // Visualizador vê dados limitados
            $clientes = Cliente::select('id', 'nome', 'email')
                             ->where('publico', true)
                             ->get();
        }
        
        return response()->json($clientes);
    }

    /**
     * Exemplo 8: Verificar permissões em massa
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $clienteIds = $request->input('cliente_ids', []);
        
        switch ($action) {
            case 'delete':
                $this->authorize('delete clientes');
                Cliente::whereIn('id', $clienteIds)->delete();
                break;
                
            case 'archive':
                // Apenas supervisores podem arquivar em massa
                if (!auth()->user()->hasRole('supervisor')) {
                    abort(403);
                }
                Cliente::whereIn('id', $clienteIds)->update(['status' => 'arquivado']);
                break;
                
            case 'export':
                $this->authorize('export relatorios');
                return $this->exportClientes($clienteIds);
                break;
        }
        
        return redirect()->back()->with('success', 'Ação executada com sucesso!');
    }

    /**
     * Exemplo 9: API com verificação de permissões
     */
    public function apiIndex()
    {
        // Para APIs, você pode verificar permissões via middleware ou diretamente
        if (!auth()->guard('api')->user()->hasPermissionTo('view clientes')) {
            return response()->json(['error' => 'Permissão negada'], 403);
        }
        
        $clientes = Cliente::all();
        
        return response()->json([
            'data' => $clientes,
            'permissions' => auth()->guard('api')->user()->getAllPermissions()->pluck('name')
        ]);
    }

    /**
     * Exemplo 10: Usar helper personalizado
     */
    public function dashboard()
    {
        $user = auth()->user();
        $dashboardData = [];
        
        // Construir dashboard baseado nas permissões
        if (PermissionHelper::hasPermission($user, 'view clientes')) {
            $dashboardData['clientes_count'] = Cliente::count();
        }
        
        if (PermissionHelper::hasPermission($user, 'view vistorias')) {
            $dashboardData['vistorias_pendentes'] = \App\Models\Vistoria::where('status', 'pendente')->count();
        }
        
        if (PermissionHelper::hasRole($user, 'administrador')) {
            $dashboardData['system_stats'] = $this->getSystemStats();
        }
        
        return view('dashboard', compact('dashboardData'));
    }

    /**
     * Método auxiliar para verificar se usuário pode editar recurso específico
     */
    private function canEditResource($resource, $user = null)
    {
        $user = $user ?? auth()->user();
        
        // Administrador pode editar tudo
        if ($user->hasRole('administrador')) {
            return true;
        }
        
        // Supervisor pode editar recursos da sua região
        if ($user->hasRole('supervisor')) {
            return $resource->regiao_id === $user->regiao_id;
        }
        
        // Técnico pode editar apenas recursos atribuídos a ele
        if ($user->hasRole('tecnico')) {
            return $resource->tecnico_responsavel_id === $user->membroEquipe->id;
        }
        
        return false;
    }
}
