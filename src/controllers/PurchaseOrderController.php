<?php namespace Controlpad\Inventory;

class PurchaseOrderController extends BaseController {
    protected $route_path = "";
  
    protected $view_path = "";  
  
    public function __construct(){

        $this->route_path = \Config::get('inventory::config.route.purchaseorders.path');
        $this->view_path = \Config::get('inventory::config.view_path.purchaseorders');
    }
	
	public function getAllPoLines(){        
        $polines = PoLineModel::all();
        return ['count'=>$this->mPoLine->count(),'data'=>$polines];
    }
    
    public function updatePoLine(){
        $poline_id = \Input::get('id');
        $item_id = \Input::get('item_id');
        $quantity = \Input::get('quantity');
        $purchaseorder_id = \Input::get('purchaseorder_id');
        
        $data = [];
        $data['purchaseorder_id'] = $purchaseorder_id; 
        $data['item_id'] = $item_id; 
        $data['qty'] = $quantity; 
        
        try{
            if(!empty($poline_id)){
                
                $poline = PoLineModel::find($poline_id);
                if(!empty($item_id)){
                    $poline->item_id = $item_id;
                }
                if(!empty($quantity)){
                    $poline->qty = $quantity;
                }
                
                $poline->save();
                
                    
            }else{
                
                $poline = PoLineModel::create($data);
            }
        }catch(\Illuminate\Database\QueryException $e){
            return ['status'=>'failed','message'=>"Error: Duplicate entry found."];    
        }
        
        return ['status'=>'success','message'=>"Successfully updated POLine!"];
    }
    
    public function updatePurchaseOrder($id){
         
        $purchaseorder = PurchaseOrderModel::find($id); 
        $total_amount = \Input::get('total_amount');
        $vendor_id = \Input::get('vendor_id');
        if(!empty($purchaseorder)){
            $purchaseorder->total_amount = $total_amount;
            $purchaseorder->vendor_id = $vendor_id;
            $purchaseorder->save();
            
            return "Successfully updated purchase order.";    
        }
        return "Purchaseorder not found.";
    }
    
    public function getPurchaseOrder($id)
    {
        
        $purchaseorder = PurchaseOrderModel::find($id);
        $purchaseorder->vendor = \App::make('Controlpad\Inventory\VendorController')->getVendor($purchaseorder->vendor_id);
        $purchaseorder->warehouse = \App::make('Controlpad\Inventory\WarehouseController')->getAllWarehouses();
        $purchaseorder->polines = PoLineModel::with('item.receives')
                                        ->where('purchaseorder_id',$id)                                      
                                        ->get();
        return $purchaseorder;
    }
    
    public function getPolines($poid){
        
        $raw = PoLineModel::with('item.products','receives')->where('purchaseorder_id',$poid);
        return ['count' => $raw->count(), 'data' => $raw->get()];
    }
    
    public function getAllPurchaseorders()
    {
       
        if(\Auth::check() && \Auth::user()->hasRole(['Superadmin', 'Admin'])){
            $data = PurchaseOrderModel::with('vendor','polines.receives');
        } else{
            $data = PurchaseOrderModel::with('vendor','polines.receives')->where('disabled', 'true');    
        } 
		
        
        return ['count' => $data->count(), 'data' => $data->get()];
    }
	
	public function purchaseOrdersReceive()
	{
		\DB::beginTransaction();		
		$purchaseorder_id = \Input::get('purchaseorder_id');
		$item_id = \Input::get('item_id');
		$actual_quantity = \Input::get('actual_quantity');
		$remaining_balance = \Input::get('remaining_balance');
                $actual_price = \Input::get('actual_price');
                $receipt_number = \Input::get('receipt_number');
                $warehouse_id = \Input::get('warehouse_id');
        
		foreach($purchaseorder_id as $key => $n ) {
			$data = [
				'purchaseorder_id' => $purchaseorder_id[$key],
				'item_id'=>$item_id[$key],
				'actual_quantity'=>$actual_quantity[$key],
				'remaining_balance'=>$remaining_balance[$key],
				'actual_price'=>$actual_price[$key],
				'receipt_number'=>$receipt_number
				];
                                   
             $validator = \Validator::make($data, ReceiveModel::$rules);          
             
			if ($validator->fails())
			{
				\DB::rollback();
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			
            if(!ReceiveModel::create($data))
			{
				\DB::rollback();
				return \Redirect::back();
			}else{
                            $inventory = array(
                                    'item_id'=>$item_id[$key],
                                    'quantity' => $actual_quantity[$key],
                                    'warehouse_id'=> $warehouse_id[$key],
                                    'disabled' => 0
                            );
                            \App::make('Controlpad\Inventory\InventoryController')->insertInventory($inventory);
                            
			
            }

       }       
		\DB::commit();
        return \Redirect::route($this->route_path.'.index')->with('message', 'Purchaseorder received.');
	}

   
       
    public function getUserPurchaseOrder($id){
        $purchaseorder = PurchaseOrderModel::where('total_amount','0')
                              ->where('user_id',$id)
                              ->first();
        return $purchaseorder;
    }
    
    
    public function index()
    {
        $basepath = $this->route_path;
        
        return \View::make($this->package_name.'::'.$this->view_path.'.index', compact('basepath'));
    }
    
    public function create()
    {
        $basepath = $this->route_path;
        
       
        $vendors = VendorModel::orderBy('name')->lists('name','id');
        array_unshift($vendors, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.create',compact('basepath','vendors'));
    }
    
    public function store()
    {
      
        
        $validator = \Validator::make($data = \Input::all(), PurchaseOrderModel::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        $data['created_by'] = \Auth::user()->first_name." ".\Auth::user()->last_name;    
      
        PurchaseOrderModel::create($data);

        
        return \Redirect::route($this->route_path.'.index')->with('message', 'Purchaseorder created.');
    }
    
    public function show($id)
    {
		$po_id = $id;       
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.show',compact('purchaseorder','basepath','po_id'));     
    }
    
    public function edit($id)
    {
        $purchaseorder = PurchaseOrderModel::find($id);
        $basepath = $this->route_path;
        $vendors = VendorModel::orderBy('name')->lists('name','id');
        array_unshift($vendors, "--select--");
        return \View::make($this->package_name.'::'.$this->view_path.'.edit', compact('purchaseorder','basepath','vendors'));
    }
    
    public function update($id)
    {
        $purchaseorder = PurchaseOrderModel::findOrFail($id);
      
        $validator = \Validator::make($data = \Input::all(), PurchaseOrderModel::$rules);

      
       
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $purchaseorder->update($data);

        return \Redirect::route($this->route_path.'.show', $id)->with('message', 'PurchaseOrder updated.');
    }
    
    public function destroy($id)
    {
        
       
        PurchaseOrderModel::destroy($id);

        return \Redirect::route($this->route_path.'.index')->with('message', 'PurchaseOrder deleted.');
    }
    
    public function disable()
    {
        foreach (\Input::get('ids') as $id) {
            PurchaseOrderModel::find($id)->update(['disabled' => 0]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'PurchaseOrders disabled.');
        }
        else {
            return \Redirect::back()->with('message', 'PurchaseOrder disabled.');
        }    
    }
    
    public function enable()
    {
        foreach (\Input::get('ids') as $id) {
            PurchaseOrderModel::find($id)->update(['disabled' => 1]);    
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'PurchaseOrders enabled.');
        }
        else {
            return \Redirect::back()->with('message', 'PurchaseOrder enabled.');
        }    
    }
    
    public function delete()
    {
        foreach (\Input::get('ids') as $id) {
            PurchaseOrderModel::destroy($id);
        }
        if (count(\Input::get('ids')) > 1) {
            return \Redirect::route($this->route_path.'.index')->with('message', 'PurchaseOrders deleted.');
        }
        else {
            return \Redirect::back()->with('message', 'PurchaseOrder deleted.');
        }    
    }    
}
?>
