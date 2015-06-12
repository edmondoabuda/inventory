<?php namespace Controlpad\Inventory;

class ItemController extends BaseController {
    protected $route_path = "";
    protected $view_path = "";
    
    public function __construct(ItemModel $mItem){
      
        $this->route_path = \Config::get('inventory::config.route.items.path');
        $this->view_path = \Config::get('inventory::config.view_path.items');
    }
    
    public function getAllItems()
    {
      
        if(\Auth::check() && \Auth::user()->hasRole(['Superadmin', 'Admin'])){
            $item = ItemModel::with('inventory');
        } else{
            $item = ItemModel::with('inventory')->where('disabled', 'true');    
        } 
        return ['count' => $item->count(), 'data' => $item->get()];
    }
    
    public function index()
    {
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.index', compact('basepath'));
    }
    
    public function create()
    {
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.create',compact('basepath'));
    }
    
    public function store()
    {
        
        $validator = \Validator::make($data = \Input::all(), ItemModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        
        ItemModel::create($data);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Item created.');
    }
    
    public function show($id)
    {
        
        $item = ItemModel::find($id);
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.show',compact('item','basepath'));     
    }
    
    public function edit($id)
    {
        
        $item = ItemModel::find($id);
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.edit', compact('item','basepath'));
    }
    
    public function update($id)
    {
        
        $item = ItemModel::findOrFail($id);
        
        
        $validator = \Validator::make($data = \Input::all(), ItemModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $item->update($data);

        return \Redirect::route($this->route_path.'.show', $id)->with('message', 'Item updated.');
    }
    
    public function destroy($id)
    {
        
        ItemModel::destroy($id);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Item deleted.');
    }
    
    public function disable()
    {
        foreach (\Input::get('ids') as $id) {
              
            ItemModel::find($id)->update(['disabled' => 0]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Items disabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Item disabled.');
        }   
    }
    
    public function enable()
    {
        foreach (\Input::get('ids') as $id) {
              
            ItemModel::find($id)->update(['disabled' => 1]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Items enabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Item enabled.');
        }     
    }
    
    public function delete()
    {
        foreach (\Input::get('ids') as $id) {
            
            ItemModel::destroy($id);
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Items deleted.');
        }
        else {
            return \Redirect::back()->with('message', 'Item deleted.');
        }    
    }     
}
?>