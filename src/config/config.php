<?php
  return array(
    'enabled' => false,
    'sidebar' => array(
        'enabled' => true
    ),
    'menu' => array(
        'inventories' => 'Inventories',
        'products' => 'Products',
        'items' => 'Items',
        'purchaseOrder' => 'PurchaseOrder',
        'warehouses' => 'Warehouses',
        'vendors' => 'Vendors',
        'all-inventories' => 'All Inventories',
        'all-products' => 'All Products',
        'all-items' => 'All Items',
        'all-purchaseorders' => 'All Purchase Orders',
        'all-warehouses' => 'All Warehouses',
        'all-vendors' => 'All Vendors',
        'all-polines' => 'All PO Lines',
        'all-transfers' => 'All Transfers',
        'receive-product' => 'Receive Product',
        'transfer-product' => 'Transfer Product',
        'new-po' => 'New PO',
        'new-inventory' => 'New Inventory',
        'new-product' => 'New Product',
        'new-item' => 'New Item',
        'new-purchaseorder' => 'New Purchaseorder',
        'new-warehouse' => 'New Warehouse',
        'new-vendor' => 'New Vendor',
        'orders' => 'Orders'
    ),
    /**
    * Override this route map inside the published config under app/config/
    */
    'route' => array(
        'inventories'=>array(
            'path' => 'controlpad-inventories',
            'receive-product'=> 'receive-product',
            'transfer-product'=> 'transfer-product',
            'new-po'=> 'new-po',
            'postTransferProduct' =>  'postTransferProduct',
        ),
        'products'=>array(
            'path' => 'inventory-products',
        ),
        'items'=>array(
            'path' => 'inventory-items',
        ),
        'purchaseorders'=>array(
            'path' => 'inventory-purchaseorders',
        ),
        'warehouses'=>array(
            'path' => 'inventory-warehouses',
        ),
        'vendors'=>array(
            'path' => 'inventory-vendors',
        ),
        'print'=>array(
            'path' => 'print',
        ),
		 'orders'=>array(
            'path' => 'inventory-orders'
        ),
        'api' => array(
            'path' => 'inv_api',
            'all-products' => 'all-products',
            'all-inventories' => 'all-inventories',
            'all-items' => 'all-items',
            'all-purchaseorders' => 'all-purchaseorders',
            'all-warehouses' => 'all-warehouses',
            'all-vendors' => 'all-vendors',
            'all-polines' => 'all-polines',
            'all-transfers' => 'all-transfers',
            'available-items' => 'available-items',
            'getWarehouse' => 'getWarehouse',
            'getPurchaseOrder' => 'getPurchaseOrder',
            'getVendor' => 'getVendor',
            'getPoLine' => 'getPoLine',
            'updatePoLine' => 'updatePoLine',
            'updatePurchaseOrder' => 'updatePurchaseOrder',
	        'purchaseOrdersReceive' => 'purchaseOrdersReceive',
            'all-orders'=>'allOrders',
            
        )
    ),
    'view_path' => array(
        'inventories' => 'controlpad-inventory',
        'items' => 'inv-item',
        'products' => 'inv-product',
        'purchaseorders' => 'inv-purchaseorder',
        'vendors' => 'inv-vendor',
		'print' => 'inv-print',
        'orders' => 'inv-orders',
    )
  );
?>
