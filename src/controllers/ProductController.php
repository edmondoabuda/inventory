<?php namespace Controlpad\Inventory;

class ProductController extends BaseController {
    
    protected $route_path = "";
    protected $view_path = "";
    protected $item_basepath = "";
    
    
    public function __construct(){
        $this->route_path = \Config::get('inventory::config.route.products.path');
        $this->view_path = \Config::get('inventory::config.view_path.products');
        $this->item_basepath = \Config::get('inventory::config.route.items.path');
    }
        
    public function getAllProducts(){
        
        if(\Auth::check() && \Auth::user()->hasRole(['Superadmin', 'Admin'])){
            $data = ProductModel::with('productitems');
        } else{
            $data = ProductModel::with('productitems')->where('disabled', 'true');    
        } 
        return ['count' => $data->count(), 'data' => $data->get()];
    }
    
    public function index()
    {   
        
        $main = ProductModel::all();
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.index',compact('main','basepath'));    
    }
    
    public function create()
    {
        $basepath = $this->route_path;
        $attachment_images = array();
        return \View::make($this->package_name.'::'.$this->view_path.'.create',compact('basepath','attachment_images'));
    }
    
    public function store()
    {
        
        $validator = \Validator::make($data = \Input::all(), ProductModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        
        ProductModel::create($data);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Product created.');
    }
    
    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
        $product = ProductModel::with('productitems.items')->find($id);
        $attachment_images = array();
        
        $basepath = $this->route_path;
        //$item_basepath = $this->item_basepath;
        return \View::make($this->package_name.'::'.$this->view_path.'.show',compact('product','attachment_images','basepath','item_basepath'));    
    }
    
    public function edit($id)
    {
        
        $product = ProductModel::find($id);
        $basepath = $this->route_path;
        $attachment_images = array();
        return \View::make($this->package_name.'::'.$this->view_path.'.edit', compact('product','basepath','attachment_images'));
    }
    
    public function update($id)
    {
        
        $product = ProductModel::findOrFail($id);

        
        $validator = \Validator::make($data = \Input::all(), ProductModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $product->update($data);

        return \Redirect::route($this->route_path.'.show', $id)->with('message', 'Product updated.');
    }
    
    public function destroy($id)
    {
        
        ProductModel::destroy($id);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Product deleted.');
    }
    
    public function disable()
    {
        foreach (\Input::get('ids') as $id) {
               
            ProductModel::find($id)->update(['disabled' => 0]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Products disabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Product disabled.');
        }    
    }
    
    public function enable()
    {
        foreach (\Input::get('ids') as $id) {
               
            ProductModel::find($id)->update(['disabled' => 1]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Products enabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Product enabled.');
        }    
    }
    
    public function delete()
    {
        foreach (\Input::get('ids') as $id) {
           
            ProductModel::destroy($id);
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Products deleted.');
        }
        else {
            return \Redirect::back()->with('message', 'Product deleted.');
        }   
    }    
}
?>
