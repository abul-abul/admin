<?php namespace App\Providers;

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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Contracts\EmailInterface',
            'App\Services\EmailService'
        );
        $this->app->bind(
            'App\Contracts\DomainInterface',
            'App\Services\DomainService'
        );
        $this->app->bind(
            'App\Contracts\FileInterface',
            'App\Services\FileService'
        );
        $this->app->bind(
            'App\Contracts\LanguageInterface',
            'App\Services\LanguageService'
        );
    }

    
}
