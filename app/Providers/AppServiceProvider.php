<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\FeedbackSistema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartilhar a contagem de feedbacks pendentes com todas as views
        View::composer('*', function ($view) {
            $feedbacksPendentes = FeedbackSistema::where('status', 'pendente')->count();
            $view->with('feedbacksPendentesCount', $feedbacksPendentes);
        });

        // Registrar middlewares do Spatie Permission como alternativa
        $router = $this->app['router'];
        $router->aliasMiddleware('role', \Spatie\Permission\Middleware\RoleMiddleware::class);
        $router->aliasMiddleware('permission', \Spatie\Permission\Middleware\PermissionMiddleware::class);
        $router->aliasMiddleware('role_or_permission', \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class);
    }
}
