<?php
##############################################################################################
// Protected Routes
##############################################################################################
Route::group(array('before' => 'auth'), function() {
    
    $route_inventories_path = \Config::get('inventory::config.route.inventories.path');
    $route_products_path = \Config::get('inventory::config.route.products.path');
    $route_items_path = \Config::get('inventory::config.route.items.path');
    $route_purchaseorders_path = \Config::get('inventory::config.route.purchaseorders.path');
    $route_warehouses_path = \Config::get('inventory::config.route.warehouses.path');
    $route_vendors_path = \Config::get('inventory::config.route.vendors.path');
	$route_orders_path = \Config::get('inventory::config.route.orders.path');
    $route_print_path = \Config::get('inventory::config.route.print.path');
    $route_api_path = \Config::get('inventory::config.route.api.path');
    Route::get($route_inventories_path.'/'.\Config::get('inventory::config.route.inventories.receive-product')."/{any}", 'Controlpad\Inventory\InventoryController@receiveProduct');
    Route::get($route_inventories_path.'/'.\Config::get('inventory::config.route.inventories.transfer-product'), 'Controlpad\Inventory\InventoryController@transferProduct');
    Route::get($route_inventories_path.'/'.\Config::get('inventory::config.route.inventories.new-po'), 'Controlpad\Inventory\InventoryController@newPO');
    
    Route::resource($route_products_path,'Controlpad\Inventory\ProductController');
    Route::post($route_products_path.'/disable', 'Controlpad\Inventory\ProductController@disable');
    Route::post($route_products_path.'/enable', 'Controlpad\Inventory\ProductController@enable');
    Route::post($route_products_path.'/delete', 'Controlpad\Inventory\ProductController@delete');
    
    Route::resource($route_items_path,'Controlpad\Inventory\ItemController');
    Route::post($route_items_path.'/disable', 'Controlpad\Inventory\ItemController@disable');
    Route::post($route_items_path.'/enable', 'Controlpad\Inventory\ItemController@enable');
    Route::post($route_items_path.'/delete', 'Controlpad\Inventory\ItemController@delete');
        
    Route::resource($route_purchaseorders_path,'Controlpad\Inventory\PurchaseOrderController');
    Route::post($route_purchaseorders_path.'/disable', 'Controlpad\Inventory\PurchaseOrderController@disable');
    Route::post($route_purchaseorders_path.'/enable', 'Controlpad\Inventory\PurchaseOrderController@enable');
    Route::post($route_purchaseorders_path.'/delete', 'Controlpad\Inventory\PurchaseOrderController@delete');
    
    Route::resource($route_warehouses_path,'Controlpad\Inventory\WarehouseController');
    Route::post($route_warehouses_path.'/disable', 'Controlpad\Inventory\WarehouseController@disable');
    Route::post($route_warehouses_path.'/enable', 'Controlpad\Inventory\WarehouseController@enable');
    Route::post($route_warehouses_path.'/delete', 'Controlpad\Inventory\WarehouseController@delete');
    
    Route::resource($route_vendors_path,'Controlpad\Inventory\VendorController');
    Route::post($route_vendors_path.'/disable', 'Controlpad\Inventory\VendorController@disable');
    Route::post($route_vendors_path.'/enable', 'Controlpad\Inventory\VendorController@enable');
    Route::post($route_vendors_path.'/delete', 'Controlpad\Inventory\VendorController@delete');
    
    Route::resource($route_inventories_path,'Controlpad\Inventory\InventoryController');
    Route::post($route_inventories_path.'/'.\Config::get('inventory::config.route.inventories.postTransferProduct'),'Controlpad\Inventory\WarehouseController@transferProduct');
    Route::post($route_inventories_path.'/disable', 'Controlpad\Inventory\InventoryController@disable');
    Route::post($route_inventories_path.'/enable', 'Controlpad\Inventory\InventoryController@enable');
    Route::post($route_inventories_path.'/delete', 'Controlpad\Inventory\InventoryController@delete');

    Route::post($route_print_path.'/all', 'Controlpad\Inventory\PrintController@printAll');
    Route::post($route_print_path.'/po', 'Controlpad\Inventory\PrintController@printPO');
    Route::post($route_print_path.'/receipt', 'Controlpad\Inventory\PrintController@printReceipt');
    
    Route::resource($route_orders_path,'Controlpad\Inventory\OrdersController');
    ##############################################################################################
    # API functions that shouldn't be cached
    ##############################################################################################
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-products'), 'Controlpad\Inventory\ProductController@getAllProducts');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-inventories'), 'Controlpad\Inventory\InventoryController@getAllInventories');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-items'), 'Controlpad\Inventory\ItemController@getAllItems');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.available-items').'/{id}', 'Controlpad\Inventory\InventoryController@getAvailableItems');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-purchaseorders'), 'Controlpad\Inventory\PurchaseOrderController@getAllPurchaseorders');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-warehouses'), 'Controlpad\Inventory\WarehouseController@getAllWarehouses');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-vendors'), 'Controlpad\Inventory\VendorController@getAllVendors');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-polines'), 'Controlpad\Inventory\PurchaseOrderController@getAllPoLines');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-transfers'), 'Controlpad\Inventory\InventoryController@getAllTransfers');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.getWarehouse').'/{id}', 'Controlpad\Inventory\WarehouseController@getWarehouse');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.getPurchaseOrder').'/{id}', 'Controlpad\Inventory\PurchaseOrderController@getPurchaseOrder');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.getVendor').'/{id}', 'Controlpad\Inventory\VendorController@getVendor');
    Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.getPoLine').'/{id}', 'Controlpad\Inventory\PurchaseOrderController@getPolines');
    Route::post($route_api_path.'/'.\Config::get('inventory::config.route.api.updatePoLine'), 'Controlpad\Inventory\PurchaseOrderController@updatePoLine');
    Route::post($route_api_path.'/'.\Config::get('inventory::config.route.api.updatePurchaseOrder').'/{id}', 'Controlpad\Inventory\PurchaseOrderController@updatePurchaseOrder');
    Route::post($route_api_path.'/'.\Config::get('inventory::config.route.api.purchaserOdersReceive').'','Controlpad\Inventory\PurchaseOrderController@purchaserOdersReceive');
    Route::post('inv_api/purchaseOrdersReceive','Controlpad\Inventory\PurchaseOrderController@purchaseOrdersReceive');
	Route::get($route_api_path.'/'.\Config::get('inventory::config.route.api.all-orders'), 'Controlpad\Inventory\OrdersController@getAllOrders');
    Route::post($route_print_path.'/all', 'Controlpad\Inventory\PrintController@printAll');       
    Route::post($route_print_path.'/po', 'Controlpad\Inventory\PrintController@printPO');       
    Route::post($route_print_path.'/receipt', 'Controlpad\Inventory\PrintController@printReceipt');       
   
    Route::get('testonly',function(){
        //return "dfafd";
        return InvMethod::deductInventory(array('item_id'=>20,'warehouse_id'=>2,'quantity'=>10,'address'=>'1r2l'));
    });
});  




Route::get('rdb-inventory', function(){

    #$html = '<html><body>'
    #        . '<p>Put your html here, or generate it with your favourite '
    #        . 'templating system.</p>'
    #        . '</body></html>';
    #return PDF::load($html, 'A4', 'portrait')->show();
    #echo Inventory::test();

    $main = \Controlpad\Inventory\MainModel::all();
    #$class = get_declared_classes();
    #$main = \Controlpad\Inventory\InventoryModel::all();
    #$main = \Controlpad\Inventory\ItemModel::all();
    #$main = \Controlpad\Inventory\ItemProductModel::all();
    #$main = \Controlpad\Inventory\PoLineModel::all();
    #$main = \Controlpad\Inventory\ProductModel::all();
    #$main = \Controlpad\Inventory\PurchaseOrderModel::all();
    #$main = \Controlpad\Inventory\TransferModel::all();
    #$main = \Controlpad\Inventory\VendorModel::all();
    #$main = \Controlpad\Inventory\WarehouseModel::all();
    //echo "<pre>".print_r($main,true)."</pre>";
    return $main;
});
?>