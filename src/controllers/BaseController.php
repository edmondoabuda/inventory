<?php namespace Controlpad\Inventory;

use Illuminate\Routing\Controller;

class BaseController extends Controller{
    
    protected $layout = 'layouts.public';
    protected $package_name = "inventory";

    public function __construct(){
       		
    }
    
    /**
    * Setup the layout used by the controller.
    * 
    * @return void
    */
    
    protected function setupLayout()
    {
        if(!is_null($this->layout))
        {
            $this->layout = \View::make($this->layout);
        }
    }
    
    /**
    * Creates a view
    * 
    * @param String $path to the view file
    * @param Array $data all the data
    * 
    * @return void
    */
    
    protected function view($path, array $data = [])
    {
        $this->layout->content = \View::make($path, $data);
    }
}
  
?>
