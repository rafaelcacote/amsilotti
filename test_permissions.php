<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

echo "=== VERIFICAÇÃO DAS PERMISSÕES DE TAREFAS ===\n\n";

// Verificar permissões de tarefas
echo "Permissões de Tarefas criadas:\n";
$tarefasPermissions = Permission::where('name', 'like', '%tarefas%')->get();

if ($tarefasPermissions->count() > 0) {
    foreach ($tarefasPermissions as $permission) {
        echo "- " . $permission->name . "\n";
    }
} else {
    echo "Nenhuma permissão de tarefas encontrada!\n";
}

echo "\n=== VERIFICAÇÃO DOS ROLES ===\n\n";

// Verificar roles
$roles = Role::all();
foreach ($roles as $role) {
    echo "Role: " . $role->name . "\n";
    $rolePermissions = $role->permissions()->where('name', 'like', '%tarefas%')->get();
    
    if ($rolePermissions->count() > 0) {
        echo "  Permissões de tarefas:\n";
        foreach ($rolePermissions as $permission) {
            echo "  - " . $permission->name . "\n";
        }
    } else {
        echo "  Sem permissões de tarefas.\n";
    }
    echo "\n";
}

echo "=== TESTE FINALIZADO ===\n";
