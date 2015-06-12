<?php namespace Controlpad\Inventory;

class WarehouseController extends BaseController {
    protected $route_path = "inventory-warehouses";
    protected $view_path = "inv-warehouse";
    
   
    public function __construct(){
        
    }
    public function getWarehouse($id)
    {
        
        $warehouse = WarehouseModel::with('inventories.item')->find($id);
        return $warehouse;
    }
        
    public function getAllWarehouses()
    {
        
        if(\Auth::check() && \Auth::user()->hasRole(['Superadmin', 'Admin'])){
            $data = WarehouseModel::with('inventories.item')->with('address');
        } else{
            $data = WarehouseModel::with('inventories.item')->with('address')
                ->where('disabled', 'true');    
    }
        return ['count' => $data->count(), 'data' => $data->get()]; 
    
    }
    
    public function getList()
    {
       
        return  WarehouseModel::orderBy('name')->lists('name','id');
    } 

     public function transferProduct()
    {         
        $items = \Input::get('item_id');       
        $quantity = \Input::get('quantity');
        $warehouse_from = \Input::get('warehouse_id_from');
        $warehouse_to = \Input::get('warehouse_id_to');
       
//        $select = array(              
//               'warehouse_id_from' =>$warehouse_from,
//               'warehouse_id_to' =>$warehouse_to
//           );
//        //dd(print_r($select));
//        $rules = [ 'warehouse_id_from' => 'required|min:1',
//                   'warehouse_id_to' => 'required|min:1'];
//        
//        $validator = \Validator::make($select, $rules);
//        if ($validator->fails())
//        {     
//            echo "error";
//            //return \Redirect::back()->withErrors($validator)->withInput();
//        } else {
//            echo 'test';
//        }
            
        
       \DB::beginTransaction(); 
       foreach($items as $key => $n ) {
            if($quantity[$key]>0){
               $dataFrom = [
                   'item_id' => $items[$key],
                   'quantity' => $quantity[$key],
                   'warehouse_id' =>$warehouse_from
               ];
               $dataTo= [
                   'item_id' => $items[$key],
                   'quantity' => $quantity[$key],
                   'warehouse_id' =>$warehouse_to
               ];
                $transfer = [
                   'item_id' => $items[$key],
                   'qty' => $quantity[$key],
                   'warehouse_id_from' =>$warehouse_from,
                   'warehouse_id_to' =>$warehouse_to
               ];  
              
                $inventory_w1 = \App::make('Controlpad\Inventory\InventoryController')->getInventory($items[$key], $warehouse_from);
                $inventory_w1->quantity = $inventory_w1->quantity - $quantity[$key];
                if($inventory_w1->quantity < 1)
                    $inventory_w1->delete();
                else
                    $inventory_w1->save();
                
                $inventory_w2 = \App::make('Controlpad\Inventory\InventoryController')->getInventory($items[$key], $warehouse_to);

                if(count($inventory_w2)>0)
                {   
                    $inventory_w2->quantity = $inventory_w2->quantity + $quantity[$key];
                    $inventory_w2->save();
                }  else 
                {
                 
                  InventoryModel::create($dataTo);
                }
                
                
                TransferModel::create($transfer);
               
            }
       }
        \DB::commit();
      return \Redirect::to('controlpad-inventories/transfer-product')->with('message', 'Successfully transfered.');
    }
    
 
    
    public function index()
    {
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.index', compact('basepath'));
    }
    
    public function create()
    {
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.create', compact('basepath'));
    }
    
    
    public function store()
    {
        $warehouse = [ 'name' => \Input::get('name')];
        $address = \Input::get('address');
        $validator = \Validator::make($warehouse, WarehouseModel::$rules);
        $validator->setAttributeNames(WarehouseModel::$custom_name);
       
        $validator = \Validator::make($data = \Input::all(), WarehouseModel::$rules);
        $validator->setAttributeNames($class::$custom_name);
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        $newWarehouse = WarehouseModel::create($warehouse);
        $newWarehouse->address()->create($address);

       

        return \Redirect::route($this->route_path.'.index')->with('message', 'Warehouse created.');
    }
    
    public function show($id)
    {
        
        $warehouse = WarehouseModel::with('inventories','address')->find($id);
        $w_inventories = $warehouse->inventories;
        $basepath = $this->route_path;
             
        return \View::make($this->package_name.'::'.$this->view_path.'.show',compact('warehouse','basepath','w_inventories'));     
    }
    
    public function edit($id)
    {
       
        $warehouse = WarehouseModel::with('address')->find($id);
        $basepath = $this->route_path;
        \Log::info($warehouse);
        return \View::make($this->package_name.'::'.$this->view_path.'.edit', compact('warehouse','basepath'));
    }
    
    public function update($id)
    {
        
        $warehouse = WarehouseModel::findOrFail($id);
        $newWarehouse = [ 'name' => \Input::get('name')];
        $address = \Input::get('address');  
        $validator = \Validator::make($newWarehouse, WarehouseModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        
        $warehouse->update($newWarehouse);
        $warehouse->address()->update($address);

        return \Redirect::route($this->route_path.'.show', $id)->with('message', 'Warehouse updated.');
    }
    
    public function destroy($id)
    {
       
        WarehouseModel::destroy($id);

        return \Redirect::route($this->route_path.'.index')->with('message', 'Warehouse deleted.');
    }
    
    public function disable()
    {
        foreach (\Input::get('ids') as $id) {
               
            WarehouseModel::find($id)->update(['disabled' => 0]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Warehouses disabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Warehouse disabled.');
        }     
    }
    
    public function enable()
    {
        foreach (\Input::get('ids') as $id) {
               
            WarehouseModel::find($id)->update(['disabled' => 1]);    
        }
        if (count(Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Warehouses enabled.');
        }
        else {
            return \Redirect::back()->with('message', 'Warehouse enabled.');
        }    
    }
    
    public function delete()
    {
        foreach (\Input::get('ids') as $id) {
           
            WarehouseModel::destroy($id);
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'Warehouses deleted.');
        }
        else {
            return \Redirect::back()->with('message', 'Warehouse deleted.');
        }    
    }      
}
?>