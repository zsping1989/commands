<?php

namespace Custom\Commands\Providers;


use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //模板代码生成
        $this->loadViewsFrom(realpath(base_path('vendor/zsping1989/commands/src/Views')), 'custom');
        //发布代码模板,方便用户自定义重写模板
        $this->publishes([
            realpath(base_path('vendor/zsping1989/commands/src/Views')) => config('view.paths')[0].'/vendor',
            realpath(base_path('vendor/zsping1989/commands/src/Models')).'/BaseModel.php' => app_path().'/BaseModel.php'
        ]);


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
