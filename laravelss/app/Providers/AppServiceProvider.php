<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::component('layouts.header','header');
        Blade::component('layouts.footer','footer');
        #后台布局  组件别名
        Blade::component('blog.layout.top','top');
        Blade::component('blog.layout.left','left');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
