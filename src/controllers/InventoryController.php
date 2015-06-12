<?php namespace Controlpad\Inventory;

class InventoryController extends BaseController {
    
    protected $route_path = "";
    protected $view_path = "";
    protected $item_basepath = "";
    

    public function __construct(){
        $this->route_path = \Config::get('inventory::config.route.inventories.path');
        $this->view_path = \Config::get('inventory::config.view_path.inventories');
    }
    
    public function getAllTransfers()
    {
        $transfers = TransferModel::with('warehouse_from','warehouse_to')->get();    
        return ['count' => TransferModel::count(), 'data' => $transfers];
    }
    
    public function getAvailableItems($id){
        $items = ItemModel::all();
        return ['data'=>$items, 'count'=>count($items)];
    }
    
    public function getInventory($item_id,$warehouse_id)
    {
        $inventory = InventoryModel::where('item_id',$item_id)
                            ->where('warehouse_id',$warehouse_id)
                            ->first();
        return $inventory;
    }
    
    public function insertInventory($paramInventory)
    {
        $inventory = $this->getInventory($paramInventory['item_id'], $paramInventory['warehouse_id']);
        if(count($inventory)>0)
        {   
            $inventory->quantity = $inventory->quantity + $paramInventory['quantity'];
            return $inventory->save();           
        }  else 
        {
           
           return  InventoryModel::create($paramInventory);
        }
        
    }
    
    public function getAllInventories()
    {
           
        if(\Auth::check() && \Auth::user()->hasRole(['Superadmin', 'Admin'])){
            $data = InventoryModel::with('item')
                ->with('warehouse');    
        } else{
            $data = InventoryModel::with('item')
                ->with('warehouse')->where('disabled', 'true');    
        } 
        return ['count' => $data->count(), 'data' => $data->get()];    
    }
        
    public function transferProduct()
    {
        $basepath = $this->route_path;        
        $warehouses = WarehouseModel::orderBy('name')->lists('name','id');
        array_unshift($warehouses, "--select--");
        $basepath = $basepath.'/'.\Config::get('inventory::config.route.inventories.postTransferProduct');
        return \View::make($this->package_name.'::'.$this->view_path.'.transfer_product', compact('basepath','warehouses'));
    }
   
    
     public function receiveProduct($po_id)
    {
        $basepath = $this->route_path;       
       // $purchaseorders = InventoryModel::where('id',$po_id)->orderBy('id')->lists('id');
        //array_unshift($purchaseorders, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.receive_product', compact('basepath','po_id'));
    }
    
    
    public function newPo()
    {
        $basepath = $this->route_path;

      
        $vendors = VendorModel::orderBy('name')->lists('name','id');
  
        array_unshift($vendors, "--select--");
        $id = \Auth::user()->id;
        
        $purchaseorder = \App::make('Controlpad\Inventory\PurchaseOrderController')
                ->getUserPurchaseOrder($id);
        if(empty($purchaseorder)){
            $purchaseorder = new PurchaseOrderModel;
            $purchaseorder->user_id = $id;
            $purchaseorder->save();
        }
        $view =  \View::make($this->package_name.'::'.$this->view_path.'.new_po', compact('basepath','vendors','purchaseorder'));
        return $view;
        $html = $view->render();
        
        return \PDF::load($html, 'A4', 'portrait')->show();
    }
    
    public function index()
    {
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.index', compact('basepath'));
    }
    
    public function create()
    {
        $basepath = $this->route_path;
       
        $warehouses = WarehouseModel::orderBy('name')->lists('name','id');
        array_unshift($warehouses, "--select--");
     
        $items = ItemModel::orderBy('name')->lists('name','id');
        array_unshift($items, "--select--");
        $states = \State::orderBy('full_name')->lists('full_name', 'abbr');
        array_unshift($states, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.create', compact('basepath','warehouses','items','states'));
    }
    
    public function store()
    {
        $type = "";
        $inv_model = \Input::get('inv-model');
        
        $data = \Input::all();
        
        
        if($inv_model == "purchaseorder"){
            $validator = \Validator::make($data, PurchaseOrderModel::$rules,PurchaseOrderModel::$messages);
        }else{
            $validator = \Validator::make($data, InventoryModel::$rules,InventoryModel::$messages);
        }
        unset($data['inv-model']);
           
              
        $validator->setAttributeNames($class::$custom_name); 
 
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        if($inv_model == "purchaseorder")
        {
            $type = "PurchaseOrder";
          
            PurchaseOrderModel::create($data);
        }else{
            $type = "Inventory";
           
            InventoryModel::create($data);
        }

        return \Redirect::route($this->route_path.'.index')->with('message', $type.' created.');
    }
    
    public function show($id)
    {
       
        $inventory = InventoryModel::with('item','warehouse')->find($id);
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.show',compact('inventory','basepath'));     
    }
    
    public function edit($id)
    {
      
        $inventory = InventoryModel::find($id);
        $basepath = $this->route_path;
      
        $warehouses = WarehouseModel::orderBy('name')->lists('name','id');
        array_unshift($warehouses, "--select--");
       
        $items = ItemModel::orderBy('name')->lists('name','id');
        array_unshift($items, "--select--");
        $states = \State::orderBy('full_name')->lists('full_name', 'abbr');
        array_unshift($states, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.edit', compact('inventory','basepath','warehouses','items','states'));
    }
    
    public function update($id)
    {
      
        $inventory = InventoryModel::findOrFail($id);

        
        $validator = \Validator::make($data = \Input::all(), InventoryModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $inventory->update($data);

        return \Redirect::route($this->route_path.'.show', $id)->with('message', 'Inventory updated.');
    }
    
    public function destroy($id)
    {
      
        InventoryModel::destroy($id);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Inventory deleted.');
    }
    
    public function disable()
    {
        foreach (\Input::get('ids') as $id) {
              
            InventoryModel::find($id)->update(['disabled' => 1]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Inventories disabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Inventory disabled.');
        }    
    }
    
    public function enable()
    {
        foreach (\Input::get('ids') as $id) {
           
            InventoryModel::find($id)->update(['disabled' => 0]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Inventories enabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Inventory enabled.');
        }    
    }
    
    public function delete()
    {
        foreach (\Input::get('ids') as $id) {
           
            InventoryModel::destroy($id);
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Inventories deleted.');
        }
        else {
            return \Redirect::back()->with('message', 'Inventory deleted.');
        }    
    }    
}
?>
