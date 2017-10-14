<?php

namespace Rafni\Auth;

use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(realpath(__DIR__ . '/routes/web.php'));
        
        // Load published views to cover possible changes to the application
        $this->loadViewsFrom($this->getPublishedViewsDirectory(), 'auth');
        
        // Load the stock views that come with the package, in case a view has not been published
        $this->loadViewsFrom($this->getViewsDirectory(), 'auth');
        
        $this->publishFiles();
        
        // Bind the Contracts to the Repositories
        $this->app->bind(\Rafni\Auth\Repositories\Users\UsersContract::class, \Rafni\Auth\Repositories\Users\UsersService::class);
        
        $this->loadMigrationsFrom($this->getMigrationsDirectory());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
    
    /**
     * Publish modifiable files of the module to make adaptations in them.
     */
    public function publishFiles()
    {
        // Publish Views
        $this->publishes([
            $this->getViewsDirectory() => $this->getPublishedViewsDirectory()
        ]);
    }
    
    /**
     * Obtain the absolute path of the package view directory
     * 
     * @return string
     */
    public function getViewsDirectory()
    {
        return realpath(__DIR__.'/resources/views');
    }
    
    /**
     * Obtain the absolute path of the package view directory
     * published in the application directory
     * 
     * @return string
     */
    public function getPublishedViewsDirectory()
    {
        return resource_path('views/vendor/rafni-auth');
    }
    
    /**
     * Obtain the absolute path of the package's migration directory
     * 
     * @return string
     */
    public function getMigrationsDirectory()
    {
        return realpath(__DIR__.'/migrations');
    }
    
}
