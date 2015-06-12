<?php
    $route_inventories_path = \Config::get('inventory::config.route.inventories.path');
    $route_products_path = \Config::get('inventory::config.route.products.path');
    $route_items_path = \Config::get('inventory::config.route.items.path');
    $route_purchaseorders_path = \Config::get('inventory::config.route.purchaseorders.path');
    $route_warehouses_path = \Config::get('inventory::config.route.warehouses.path');
    $route_vendors_path = \Config::get('inventory::config.route.vendors.path');
    $route_api_path = \Config::get('inventory::config.route.api.path');
    
    $route_receive_product_path = \Config::get('inventory::config.route.inventories.receive-product');
    $route_transfer_product_path = \Config::get('inventory::config.route.inventories.transfer-product');
    $route_new_po_path = \Config::get('inventory::config.route.inventories.new-po');
    
    $menu_inventories = \Config::get('inventory::config.menu.inventories');
    $menu_products = \Config::get('inventory::config.menu.products');
    $menu_items = \Config::get('inventory::config.menu.items');
    $menu_purchaseOrder = \Config::get('inventory::config.menu.purchaseOrder');
    $menu_warehouses = \Config::get('inventory::config.menu.warehouses');
    $menu_vendors = \Config::get('inventory::config.menu.vendors');
    
    $menu_all_inventories = \Config::get('inventory::config.menu.all-inventories');
    $menu_all_products = \Config::get('inventory::config.menu.all-products');
    $menu_all_items = \Config::get('inventory::config.menu.all-items');
    $menu_all_purchaseorders = \Config::get('inventory::config.menu.all-purchaseorders');
    $menu_all_warehouses = \Config::get('inventory::config.menu.all-warehouses');
    $menu_all_vendors = \Config::get('inventory::config.menu.all-vendors');
    $menu_all_polines = \Config::get('inventory::config.menu.all-polines');
    $menu_all_transfers = \Config::get('inventory::config.menu.all-transfers');
    $menu_receive_product = \Config::get('inventory::config.menu.receive-product');
    $menu_transfer_product = \Config::get('inventory::config.menu.transfer-product');
    $menu_new_po = \Config::get('inventory::config.menu.new-po');
    $menu_new_inventory = \Config::get('inventory::config.menu.new-inventory');
    $menu_new_product = \Config::get('inventory::config.menu.new-product');
    $menu_new_item = \Config::get('inventory::config.menu.new-item');
    $menu_new_purchaseorder = \Config::get('inventory::config.menu.new-purchaseorder');
    $menu_new_warehouse = \Config::get('inventory::config.menu.new-warehouse');
    $menu_new_vendor = \Config::get('inventory::config.menu.new-vendor');

?>
        <a href="javascript:void(0)" data-href="/{{$route_inventories_path}}" class='list-group-item' data-toggle="popover" data-content="
             <a href='/{{$route_inventories_path}}'><i class='fa fa-cubes'></i> {{$menu_all_inventories}}</a>
             <a href='/{{$route_inventories_path}}/{{$route_transfer_product_path}}'><i class='fa fa-arrows'></i> {{$menu_transfer_product}}</a>
             <a href='/{{$route_inventories_path}}/{{$route_new_po_path}}'><i class='fa fa-plus'></i> {{$menu_new_po}}</a>
             <a href='/{{$route_inventories_path}}/create'><i class='fa fa-plus'></i> {{$menu_new_inventory}}</a>
        ">
             <i class="fa fa-cubes"></i> <span class="text">{{$menu_inventories}}</span>
        </a>
        <a href="javascript:void(0)" data-href="/{{$route_products_path}}" class='list-group-item' data-toggle="popover" data-content="
             <a href='/{{$route_products_path}}'><i class='fa fa-suitcase'></i> {{$menu_all_products}}</a>
             <a href='/{{$route_products_path}}/create'><i class='fa fa-plus'></i> {{$menu_new_product}}</a>
        ">
             <i class="fa fa-suitcase"></i> <span class="text">{{$menu_products}}</span>
        </a>
        <a href="javascript:void(0)" data-href="/{{$route_items_path}}" class='list-group-item' data-toggle="popover" data-content="
             <a href='/{{$route_items_path}}'><i class='fa fa-qrcode'></i> {{$menu_all_items}}</a>
             <a href='/{{$route_items_path}}/create'><i class='fa fa-plus'></i> {{$menu_new_item}}</a>
        ">
             <i class="fa fa-qrcode"></i> <span class="text">{{$menu_items}}</span>
        </a>
        <a href="javascript:void(0)" data-href="/{{$route_purchaseorders_path}}" class='list-group-item' data-toggle="popover" data-content="
             <a href='/{{$route_purchaseorders_path}}'><i class='fa fa-reorder'></i> {{$menu_all_purchaseorders}}</a>
             <!--<a href='/{{$route_purchaseorders_path}}/create'><i class='fa fa-plus'></i> {{$menu_new_purchaseorder}}</a>-->
        ">
             <i class="fa fa-reorder"></i> <span class="text">{{$menu_purchaseOrder}}</span>
        </a>
        <a href="javascript:void(0)" data-href="/{{$route_warehouses_path}}" class='list-group-item' data-toggle="popover" data-content="
             <a href='/{{$route_warehouses_path}}'><i class='fa fa-building-o'></i> {{$menu_all_warehouses}}</a>
             <a href='/{{$route_warehouses_path}}/create'><i class='fa fa-plus'></i> {{$menu_new_warehouse}}</a>
        ">
             <i class="fa fa-building-o"></i> <span class="text">{{$menu_warehouses}}</span>
        </a>
        <a href="javascript:void(0)" data-href="/{{$route_vendors_path}}" class='list-group-item' data-toggle="popover" data-content="
             <a href='/{{$route_vendors_path}}'><i class='fa fa-bus'></i> {{$menu_all_vendors}}</a>
             <a href='/{{$route_vendors_path}}/create'><i class='fa fa-plus'></i> {{$menu_new_vendor}}</a>
        ">
             <i class="fa fa-bus"></i> <span class="text">{{$menu_vendors}}</span>
        </a>
    
