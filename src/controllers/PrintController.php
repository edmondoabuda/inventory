<?php namespace Controlpad\Inventory;

class PrintController extends BaseController {
    
    protected $route_path = "print-view";
    protected $view_path = "inv-print";
    protected $item_basepath = "";
    protected $inv_path = '\Controlpad\Inventory\\';

    protected $key;
    protected $viewName;
    protected $modelName;
    protected $data;
    

    
    
    public function __construct(){
        
    }

   
  
    
    
    public function index(){
       return \Input::all();
    }

    public function printAll(){
        $input = \Input::all();
        
        $this->processInfo($input);
        $data = $this->data;
        \Log::info($data);
        $viewName = $this->viewName;
        $currentDate = date('l, M d Y');
        $view = \View::make($this->package_name.'::'.$this->view_path.".$viewName", 
            compact('basepath','data', 'currentDate'));
        // //return $data;       
        return \PDF::load($view, 'letter', 'landscape')->show();
        //return json_encode(array('innerHtml' => \PDF::load($view, 'A4', 'landscape')->show()));
       
    }

    public function printPO(){
        $input = \Input::all();
        
        $this->processInfo($input);
        $data = $this->data;
        \Log::info($data);
        $viewName = $this->viewName;
        $currentDate = date('l, M d, Y');
        $view = \View::make($this->package_name.'::'.$this->view_path.".$viewName", 
            compact('basepath','data', 'currentDate'));
        \Log::info($view);
        // //return $data;       
        try{
            $pdf = \PDF::load($view, 'letter', 'portrait')->show();    
            return $pdf;
        } catch(Exception $e){
            \Log::info($e->getTrace());
            \Log::info($_dompdf_warnings);
        }
        return $view;
        //return json_encode(array('innerHtml' => \PDF::load($view, 'A4', 'landscape')->show()));
       
    }

    public function printReceipt(){
        $input = \Input::all();
        
        $this->processInfo($input);
        $data = $this->data;
        \Log::info($data);
        $viewName = $this->viewName;
        $currentDate = date('l, M d Y');
        $view = \View::make($this->package_name.'::'.$this->view_path.".$viewName", 
            compact('basepath','data', 'currentDate'));
        // //return $data;       
        return \PDF::load($view, 'letter', 'portrait')->show();
        //return json_encode(array('innerHtml' => \PDF::load($view, 'A4', 'landscape')->show()));
       
    }

    public function show($modelName){
        return \Input::all(); 
    }

    public function store(){
        return \Input::all();
    }

    private function processInfo($array){
        $key = $this->getKey($array);
        $this->viewName = $key;
        $this->modelName = $this->getModelName($key);
        $this->data = json_decode($array[$key], true);
    }

    private function getKey($array){
        $keys = array_keys($array);
        if(count($keys) > 1){
            \Log::warning('Multiple keys found.');
        }
        return $keys[0];
    }

    private function getModelName($key){
        $str = $key;
        $str[0] = strtoupper($key[0]);
        return "\Controlpad\Inventory\\".$str."Model";
    }

}
?>
