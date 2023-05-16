<?php

namespace Modules\Comment\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use Illuminate\Support\Facades\DB;
use Schema;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * The namespace for the module's models.
     *
     * @var string
     */
    protected $modelNamespace = 'Modules\Comment\Models';

    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        // Your module's boot logic here
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->ViewPaths();
        $this->adminViewPaths();
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        // Your module's register logic here
    }
    
    public function ViewPaths() {
        $moduleLower = lcfirst('Comment');
        if (Schema::hasTable('settings')) {
            $setting = DB::table('settings')->where('id', 'site.theme')->first();
            $currentTheme = $setting->value;
        } else {
            $currentTheme = 'default';
        }
        $views = [
            base_path("themes/$currentTheme/views/modules/Comment"),
            module_Viewpath('Comment', $currentTheme),
            base_path("themes/default/views/modules/Comment"),
            module_Viewpath('Comment', 'default'),
            base_path("resources/views/modules/Comment"),
        ];

        return $this->loadViewsFrom($views, $moduleLower);
    }

    public function adminViewPaths() {
        $moduleLower = lcfirst('Comment');
        $currentTheme = 'admin';
        $views = [
            module_Viewpath('Comment', $currentTheme),
            base_path("themes/$currentTheme/views/modules/Comment"),
        ];

        return $this->loadViewsFrom($views, $moduleLower.'-admin');
    }
}

