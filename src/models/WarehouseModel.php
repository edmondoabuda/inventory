<?php
namespace Controlpad\Inventory;

class WarehouseModel extends MainModel {
    protected $table = 'warehouses';
    
    public static $rules = [
      'name' => 'required'
    ];
    public static $custom_name = [
     'name' => 'Name'
    ];
    
   
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function inventories()
    {
        return $this->hasMany('Controlpad\Inventory\InventoryModel','warehouse_id');
    }
    
    public function address()
    {
        return $this->morphOne('Address', 'addressable');
}
    
}
?>
