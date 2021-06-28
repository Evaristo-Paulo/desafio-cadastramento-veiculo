<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Modelo;
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
            $version_global = \DB::table('versions')
                ->join('tip_versions', 'versions.id', '=', 'tip_versions.version_id')
                ->select('versions.*')
                ->groupBy('versions.name')
                ->get();
             
            $type_global = Type::where('active', 1)->get();
            $brand_global = Brand::where('active', 1)->get();
            $model_global = Modelo::where('active', 1)->get();

            View::share(compact('tip_version_global', 'model_global','brand_global','version_global', 'type_global'));
        }
    }
}
