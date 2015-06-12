<?php namespace Controlpad\InvMethod;

use Illuminate\View\Environment;
use Illuminate\View\Factory;
use Illuminate\Config\Repository;
use Controlpad\Inventory\InventoryModel;
use Controlpad\Inventory\ItemModel;

class InvMethod {
    /**
    * Illuminate view Factory.
    * 
    * @var Illuminate\View\Factory
    * 
    */
    
    protected $view;
    
    /**
    * Illuminate config repository
    * 
    * @var Illuminate\Config\Repository
    */
    
    protected $config;
    
    /**
    * Create a new profiler instance.
    * 
    * @param Illuminate\View\Factory $view
    * @return void
    * 
    */
    
    public function __construct(Factory $view, Repository $config)
    {
        $this->view = $view;    
        $this->config = $config;
    }
    
    /**
    * test
    * 
    */
    public function getInventory($items,it){
        return InventoryModel::where('item_id',$items['item_id'])
                                    ->where('warehouse_id',$items['warehouse_id']) 
                                    ->where('address',$items['address'])                                  
                                    ->first();
    }

    /**
     * Description of the function.
     *
     * @param array $items [,int $warehouse_id]
     *
     * @return count of the item with the least quantity
     */
    public function getItemCount($items,$warehouse_id=null) {
        if(is_null($warehouse_id)){
            return InventoryModel::where('item_id',$items->id)                                                                   
                                    ->sum('quantity');
        }else{
            return InventoryModel::where('item_id',$items->id)
                                    ->where('warehouse_id',$warehouse_id)                                   
                                    ->sum('quantity');
        }  

    }

    /**
     * Description of the function.
     *
     * @params array $items [,int $warehouse_id]
     *
     * @return boolean
     */
    public function ItemAvailable($items,$warehouse_id=null)
    {
        $inventory = $this->getItemCount($items,$warehouse_id);                                 
        return ($inventory > 0) ? true : false;
        
    }
   /**
     * Description of the function.
     *
     * @param 
     *
     * @return int item_id
     */
    public function addItem($item) 
    {

        $item = ItemModel::create($item);
        return $item->id;
    }

    /**
     * Description of the function.
     *
     * @param $item_id
     *
     * @return boolean
     */
    public function deleteItem($item_id) 
    {
        return ItemModel::destroy($item_id);
    }

    /**
     * Description of the function.
     *
     * @param $items ids and quantities
     *
     * @return boolean
     */
    public function deductInventory($items,$warehouse_id=null)
    {
        $inventory = $this->getInventory($items,$warehouse_id);
        $inventory->quantity =  $inventory->quantity - $items->quantity ;  
        return ($inventory->save()) ? true : false;                       
    }

    /**
     * Description of the function.
     *
     * @param $items ids and quantities
     *
     * @return boolean
     */
    public function addInventory($items,$warehouse_id)
    {
        $inventory = $this->getInventory($items,$warehouse_id);
       
        if(!is_null($inventory)){
            $inventory->quantity = $inventory->quantity + $items->quantity;
            return ($inventory->save()) ? true : false ;
        }
        else{
            return (InventoryModel::create($items)) ? true : false;
        }
    }


}