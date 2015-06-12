<?php namespace Controlpad\Inventory;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class InventoryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('controlpad/inventory');
        
        include __DIR__.'/../../routes.php';
        
        $app = $this->app;
        
        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = AliasLoader::getInstance();
            $loader->alias('Inventory', 'Controlpad\Inventory\Facades\Inventory');
        });
        
        $default_dbconfig = $this->app['config']['database.connections.mysql'];
        $temp_dbconfig = array();
   
        $ctrlpadinv_dbconfig = \Config::get('inventory::database.connections.controlpad-inventory');
        
        foreach($default_dbconfig as $field => $value){
            if(array_key_exists($field, $ctrlpadinv_dbconfig)){
                $temp_dbconfig[$field] = $ctrlpadinv_dbconfig[$field];
            }else{
                $temp_dbconfig[$field] = $value;        
            }
        }
        
        $this->app['config']['database.connections'] = array_merge(
            $this->app['config']['database.connections'],
            array('controlpad-inventory'=>$temp_dbconfig)
        );
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['inventory'] = $this->app->share(function($app)
        {
            return new Inventory($app['view'], $app['config']);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('inventory');
	}

}
