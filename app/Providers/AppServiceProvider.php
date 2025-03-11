<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Register the statusColor helper function for use in Blade templates
        Blade::directive('statusColor', function ($status) {
            return "<?php echo \App\Helpers\StatusHelper::statusColor($status); ?>";
        });
    }
}
