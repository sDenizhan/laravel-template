<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        Model::unguard();

        $themeName = Config::get('view.theme', 'default');
        Config::push('view.paths', resource_path(Arr::join(['views', 'themes', 'backend', $themeName], DIRECTORY_SEPARATOR)));

        //livewire path set ediliyor
        //Config::set('livewire.view_path', Str::replace('{theme}', $themeName, Config::get('livewire.view_path')));


        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
    }
}
