<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Illuminate\Database\Eloquent\Relations\Relation;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

   

    public function register()
    {
        Passport::ignoreMigrations();
        Passport::routes(null, ['middleware' => [
            // You can make this simpler by creating a tenancy route group
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class,
        ]]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::loadKeysFrom(base_path(config('passport.key_path')));

        \Event::listen(TenancyBootstrapped::class, function (TenancyBootstrapped $event) {
            \Spatie\Permission\PermissionRegistrar::$cacheKey = 'spatie.permission.cache.tenant.' . $event->tenancy->tenant->id;
        });

        Relation::morphMap([
            'Form' => 'App\Models\Form',
            'Field' => 'App\Models\Field',
        ]);
    }
  
}

