<?php
namespace Controlpad\Inventory;

class InventoryModel extends MainModel {
    protected $table = 'inventories';
    
    public static $rules = [
     'warehouse_id' => 'required|numeric|min:1',
     'item_id' => 'required|numeric|min:1',
     'quantity' => 'required|numeric'
    ];
    
     public static $custom_name = [
     'warehouse_id' => 'Warehouse',
     'item_id' => 'Item',
     'quantity' => 'Quantity'
    ];

    public static $messages =[
        'warehouse_id.min' => "The :attribute field is required",
        'item_id.min' => "The :attribute field is required"
    ];
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function item()
    {
        return $this->belongsTo('Controlpad\Inventory\ItemModel','item_id');    
    }
    public function warehouse()
    {
        return $this->belongsTo('Controlpad\Inventory\WarehouseModel','warehouse_id');    
    }
}
?>
