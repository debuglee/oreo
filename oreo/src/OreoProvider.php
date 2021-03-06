<?php
namespace Hqbox\Oreo;
use Illuminate\Support\ServiceProvider;
class OreoProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // // 发布配置文件
        // $this->publishes([
        //     __DIR__.'/config/avatar.php' => config_path('avatar.php'),
        // ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('oreo', function ($app) {
            // return new Oreo($app['config']);
            return new Oreo();
        });
    }
}

