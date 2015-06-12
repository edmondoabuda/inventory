<?php namespace Controlpad\Inventory;

class VendorController extends BaseController {
    protected $route_path = "";
    protected $view_path = "";
    
    public function __construct(){
        $this->route_path = \Config::get('inventory::config.route.vendors.path');
        $this->view_path = \Config::get('inventory::config.view_path.vendors');
    }
    
    public function getList(){
        return VendorModel::orderBy('name')->lists('name','id');
    }
    
    public function getVendor($id)
    {
      
        $vendor = VendorModel::find($id);
        return $vendor;
    }
    
    public function getAllVendors()
    {
       
        if(\Auth::check() && \Auth::user()->hasRole(['Superadmin', 'Admin'])){
            $data = VendorModel::with('address');
        } else{
            $data = VendorModel::with('address')->where('disabled', 'true');    
    }
        return ['count' => $data->count(), 'data' => $data->get()];
    }
    
    public function index()
    {
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.index', compact('basepath'));
    }
    
    public function create()
    {
        $basepath = $this->route_path;
        $states = \State::orderBy('full_name')->lists('full_name', 'abbr');
        array_unshift($states, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.create',compact('basepath','states'));
    }
    
    public function store()
    {         
       
        $validator = \Validator::make($data = \Input::all(), VendorModel::$rules);
        $validator->setAttributeNames($class::$custom_name);
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

       
        VendorModel::create($data);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Vendor created.');
    }
    
    public function show($id)
    {
       
        $vendor = VendorModel::find($id);
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.show',compact('vendor','basepath'));     
    }
    
    public function edit($id)
    {
       
        $vendor = VendorModel::with('address')->find($id);
        $basepath = $this->route_path;
        $states = \State::orderBy('full_name')->lists('full_name', 'abbr');
        array_unshift($states, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.edit', compact('vendor','basepath','states'));
    }
    
    public function update($id)
    {
                $vendor = VendorModel::findOrFail($id);
        $newVendor = [ 'name' => \Input::get('name'),
                       'email' => \Input::get('email'),
                       'phone' => \Input::get('phone')
            ];
        $address = \Input::get('address'); 
        $validator = \Validator::make($newVendor, VendorModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        
        $vendor->update($newVendor);
        $vendor->address()->update($address);

        return \Redirect::route($this->route_path.'.show', $id)->with('message', 'Vendor updated.');
    }
    
    public function destroy($id)
    {
       
        VendorModel::destroy($id);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Vendor deleted.');
    }
    
    public function disable()
    {
        foreach (\Input::get('ids') as $id) {
               
            VendorModel::find($id)->update(['disabled' => 0]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Vendors disabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Vendor disabled.');
        }    
    }
    
    public function enable()
    {
        foreach (\Input::get('ids') as $id) {
             
            VendorModel::find($id)->update(['disabled' => 1]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Vendors enabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Vendor enabled.');
        }     
    }
    
    public function delete()
    {
        foreach (\Input::get('ids') as $id) {
            
            VendorModel::destroy($id);
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Vendors deleted.');
        }
        else {
            return \Redirect::back()->with('message', 'Vendor deleted.');
        }   
    }    
}
?>
