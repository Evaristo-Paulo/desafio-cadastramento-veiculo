<?php

namespace App\Providers;

use App\Models\Version;
use App\Models\TipVersion;
use App\Models\Type;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            $tip_version_global = TipVersion::all();
            $version_global = Version::all();
            $type_global = Type::where('active', 1)->get();

            View::share(compact('tip_version_global', 'version_global', 'type_global'));
        }
    }
}
