<?php



use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViaEspecificaController;
use Illuminate\Http\Request;
use App\Http\Controllers\CarrinhoController;

Route::resource('vias-especificas', ViaEspecificaController::class)->parameters(['vias-especificas' => 'viaEspecifica'])->middleware('auth');

Route::redirect('/', '/login');

Route::get('/dashboard', function(Request $request) {
    if (auth()->user()->hasRole('cliente_amostra')) {
        return redirect()->route('consulta.cliente.index');
    }
    return app(\App\Http\Controllers\DashboardController::class)->index($request);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/storage/fotos_imoveis/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);

    if (!Storage::exists('public/' . $filename)) {
        abort(404);
    }

    return Response::file($path);
});

Route::post('/print-map', [\App\Http\Controllers\ImovelController::class, 'printMap'])->name('print.map');

Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('ordens-de-servico', \App\Http\Controllers\OrdemDeServicoController::class)->parameters(['ordens-de-servico' => 'ordemDeServico'])->middleware('auth');

Route::resource('zonas', \App\Http\Controllers\ZonaController::class)->middleware('auth');

Route::resource('bairros', \App\Http\Controllers\BairroController::class)->middleware('auth');
Route::get('/bairro/{id}', [\App\Http\Controllers\BairroController::class, 'getBairroData'])->name('getBairroData')->middleware('auth');


Route::get('vistorias/{id}/imprimir', [\App\Http\Controllers\VistoriaController::class, 'imprimirIndividual'])->name('vistorias.imprimir_unica')->middleware('auth');
Route::get('vistorias/{id}/teste-imprimir', [\App\Http\Controllers\VistoriaController::class, 'testeImprimir'])->name('vistorias.teste_imprimir')->middleware('auth');
Route::get('vistorias/{id}/delete-info', [\App\Http\Controllers\VistoriaController::class, 'getDeleteInfo'])->name('vistorias.delete-info')->middleware('auth');
Route::resource('vistorias', \App\Http\Controllers\VistoriaController::class)->middleware('auth');
Route::get('vistorias/agenda-vistoria', [\App\Http\Controllers\VistoriaController::class, 'agendaVistoria'])->name('vistorias.agenda_vistoria')->middleware('auth');
Route::get('vistorias-imprimir', [\App\Http\Controllers\VistoriaController::class, 'imprimir'])->name('vistorias.imprimir')->middleware('auth');
Route::delete('vistorias/fotos/{id}', [\App\Http\Controllers\VistoriaController::class, 'deleteFoto'])->name('vistorias.delete-foto')->middleware('auth');

Route::resource('membro-equipe-tecnicas', \App\Http\Controllers\MembroEquipeTecnicaController::class)->parameters(['membro-equipe-tecnicas' => 'membroEquipeTecnica'])->middleware('auth');

Route::resource('imoveis', \App\Http\Controllers\ImovelController::class)->parameters(['imoveis' => 'imovel'])->middleware('auth');
Route::post('/imoveis/get-selected-data', [\App\Http\Controllers\ImovelController::class, 'getSelectedData'])->name('imoveis.getSelectedData')->middleware('auth');
Route::post('/imoveis/print-map-direct', [\App\Http\Controllers\ImovelController::class, 'printMapDirect'])->name('imoveis.printMapDirect')->middleware('auth');
Route::get('/search-vias-especificas', [\App\Http\Controllers\ImovelController::class, 'searchViasEspecificas'])->name('searchViasEspecificas');
Route::get('/gerar-pdf/{id}', [\App\Http\Controllers\ImovelController::class, 'gerarPdf'])->middleware('auth')->name('gerar.pdf');
//Route::get('/imoveis/print-selected', [\App\Http\Controllers\ImovelController::class, 'gerarPdfLote'])->name('imoveis.printSelected');
Route::get('/imoveis/gerar-pdf-multiplo/{ids}', [\App\Http\Controllers\ImovelController::class, 'gerarMultiploPdf'])->name('gerar.multiple.pdf')->middleware('auth');
Route::get('/gerar-pdf-multiplo-resumido/{ids}', [\App\Http\Controllers\ImovelController::class, 'gerarPdfMultiploResumido'])->middleware('auth')->name('gerar.multiple.pdf.resumido');
Route::delete('fotos/{foto}', [\App\Http\Controllers\ImovelController::class, 'destroyFoto'])
    ->name('fotos.destroyFoto')
    ->middleware('auth');


Route::resource('clientes', \App\Http\Controllers\ClienteController::class)->middleware('auth');

// API para busca de clientes (autocomplete)
Route::get('/api/clientes/search', function (\Illuminate\Http\Request $request) {
    $term = $request->input('term');
    $clientes = \App\Models\Cliente::where('nome', 'like', "%{$term}%")
        ->orWhere('empresa', 'like', "%{$term}%")
        ->limit(10)
        ->get(['id', 'nome', 'tipo']);
    return response()->json($clientes);
})->middleware('auth')->name('api.clientes.search');

// Rotas para Controle de Perícias
Route::resource('controle-pericias', \App\Http\Controllers\ControlePericiasController::class)->middleware('auth');
Route::get('autocomplete-clientes', [\App\Http\Controllers\ControlePericiasController::class, 'autocompleteClientes'])->middleware('auth');
Route::get('controle-pericias/{id}/print', [\App\Http\Controllers\ControlePericiasController::class, 'printPdf'])->name('controle-pericias.print')->middleware('auth');

Route::resource('controle_de_tarefas', \App\Http\Controllers\ControleDeTarefasController::class)
    ->parameters(['controle_de_tarefas' => 'controleDeTarefas'])
    ->middleware('auth');
Route::patch('controle_de_tarefas/{controleDeTarefas}/status', [\App\Http\Controllers\ControleDeTarefasController::class, 'updateStatus'])
    ->name('controle_de_tarefas.update_status')
    ->middleware('auth');
Route::patch('controle_de_tarefas/{controleDeTarefas}/situacao', [\App\Http\Controllers\ControleDeTarefasController::class, 'updateSituacao'])
    ->name('controle_de_tarefas.update_situacao')
    ->middleware('auth');

    Route::get('/controle_de_tarefas/{controleDeTarefa}/duplicate', [\App\Http\Controllers\ControleDeTarefasController::class, 'duplicate'])
    ->name('controle_de_tarefas.duplicate')->middleware('auth');
    Route::post('/controle-de-tarefas/exportar-para-impressao', [\App\Http\Controllers\ControleDeTarefasController::class, 'exportarParaImpressao'])
    ->name('controle_de_tarefas.exportar_para_impressao')->middleware('auth');


Route::resource('agenda', \App\Http\Controllers\AgendaController::class)->middleware('auth');
Route::get('agenda/{agenda}/imprimir', [\App\Http\Controllers\AgendaController::class, 'imprimir'])->name('agenda.imprimir')->middleware('auth');
Route::get('agenda/search-cliente', [\App\Http\Controllers\AgendaController::class, 'searchCliente'])->name('agenda.searchCliente')->middleware('auth');
Route::get('agenda-eventos', [\App\Http\Controllers\AgendaController::class, 'getEventos'])->name('agenda.eventos')->middleware('auth');

// Rotas para Tipos de Evento
Route::resource('tipos-de-evento', \App\Http\Controllers\TipoDeEventoController::class)->middleware('auth');


Route::post('feedback_sistema/{id}/resolver', [\App\Http\Controllers\FeedbackSistemaController::class, 'resolver'])->name('feedback_sistema.resolver')->middleware('auth');
Route::resource('feedback_sistema', \App\Http\Controllers\FeedbackSistemaController::class)->middleware('auth');

// Rotas de Gestão de Usuários
Route::middleware(['auth', 'permission:view users'])->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class);
});

// Rotas de Gestão de Roles (Perfis)
Route::middleware(['auth', 'permission:manage settings'])->group(function () {
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
});

// Rotas de Gestão de Usuários e Permissões
Route::middleware(['auth', 'permission:manage settings'])->prefix('user-permissions')->name('user-permissions.')->group(function () {
    Route::get('/', [\App\Http\Controllers\UserPermissionController::class, 'index'])->name('index');
    Route::get('/{user}/edit', [\App\Http\Controllers\UserPermissionController::class, 'edit'])->name('edit');
    Route::put('/{user}', [\App\Http\Controllers\UserPermissionController::class, 'update'])->name('update');
    Route::get('/user/{user}/data', [\App\Http\Controllers\UserPermissionController::class, 'getUserData'])->name('user-data');
    Route::post('/assign-role', [\App\Http\Controllers\UserPermissionController::class, 'assignRole'])->name('assign-role');
    Route::post('/remove-role', [\App\Http\Controllers\UserPermissionController::class, 'removeRole'])->name('remove-role');
    Route::post('/give-permission', [\App\Http\Controllers\UserPermissionController::class, 'givePermission'])->name('give-permission');
    Route::post('/revoke-permission', [\App\Http\Controllers\UserPermissionController::class, 'revokePermission'])->name('revoke-permission');
});

// Rotas de Gestão de Permissões
Route::middleware(['auth', 'permission:manage settings'])->prefix('permissions')->name('permissions.')->group(function () {
    Route::get('/', [\App\Http\Controllers\PermissionController::class, 'index'])->name('index');
    Route::post('/assign-role', [\App\Http\Controllers\PermissionController::class, 'assignRole'])->name('assign-role');
    Route::post('/remove-role', [\App\Http\Controllers\PermissionController::class, 'removeRole'])->name('remove-role');
    Route::post('/give-permission', [\App\Http\Controllers\PermissionController::class, 'givePermission'])->name('give-permission');
    Route::post('/revoke-permission', [\App\Http\Controllers\PermissionController::class, 'revokePermission'])->name('revoke-permission');
    Route::post('/sync-roles', [\App\Http\Controllers\PermissionController::class, 'syncRoles'])->name('sync-roles');
    Route::get('/user/{userId}', [\App\Http\Controllers\PermissionController::class, 'getUserData'])->name('user-data');
    Route::post('/check-permissions', [\App\Http\Controllers\PermissionController::class, 'checkUserPermissions'])->name('check-permissions');
});

// Rota de teste para middleware de permissões
Route::middleware(['auth'])->get('/test-permission', [\App\Http\Controllers\TestPermissionController::class, 'test'])->name('test.permission');

// Rota de teste visual para permissões
Route::middleware(['auth'])->get('/test-permissions-view', function () {
    return view('test-permissions');
})->name('test.permissions.view');

// Rotas de Administração de Permissões
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/permissions', [\App\Http\Controllers\PermissionManagementController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [\App\Http\Controllers\PermissionManagementController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [\App\Http\Controllers\PermissionManagementController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [\App\Http\Controllers\PermissionManagementController::class, 'destroy'])->name('permissions.destroy');
    Route::post('/permissions/assign-role', [\App\Http\Controllers\PermissionManagementController::class, 'assignToRole'])->name('permissions.assign-role');
    Route::post('/permissions/create-module', [\App\Http\Controllers\PermissionManagementController::class, 'createModule'])->name('permissions.create-module');
    Route::get('/permissions/by-group', [\App\Http\Controllers\PermissionManagementController::class, 'getByGroup'])->name('permissions.by-group');
});

// Rotas para Consulta de Cliente (perfil Cliente Amostra)
Route::middleware(['auth', 'role:cliente_amostra'])->prefix('consulta-cliente')->name('consulta.cliente.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ConsultaClienteController::class, 'index'])->name('index');
    Route::get('/{imovel}', [\App\Http\Controllers\ConsultaClienteController::class, 'show'])->name('show');
});

Route::middleware(['auth', 'role:cliente_amostra'])->group(function () {
    Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');
    Route::post('/carrinho/adicionar', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
    Route::post('/carrinho/remover', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
    Route::get('/carrinho/contador', [CarrinhoController::class, 'contador'])->name('carrinho.contador');
});

require __DIR__ . '/auth.php';
