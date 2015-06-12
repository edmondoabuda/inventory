<?php namespace Controlpad\Inventory;

use Illuminate\View\Environment;
use Illuminate\View\Factory;
use Illuminate\Config\Repository;

class Inventory {
    /**
    * Illuminate view Factory.
    * 
    * @var Illuminate\View\Factory
    * 
    */
    
    protected $view;
    
    /**
    * Illuminate config repository
    * 
    * @var Illuminate\Config\Repository
    */
    
    protected $config;
    
    /**
    * Create a new profiler instance.
    * 
    * @param Illuminate\View\Factory $view
    * @return void
    * 
    */
    
    public function __construct(Factory $view, Repository $config)
    {
        $this->view = $view;    
        $this->config = $config;
    }
    
    /**
    * test
    * 
    */
    public function generateMenu(){
        if($this->config->get('inventory::config.sidebar.enabled',true)){
            return $this->view->make('inventory::controlpad-inventory.menu');
        }
    }
}