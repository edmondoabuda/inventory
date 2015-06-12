<?php

namespace Controlpad\Inventory;

class ItemModel extends MainModel {
    protected $table = 'items';
    
    public static $rules = [
     'name' => 'required',
     'weight'=>'required|numeric',
     'volume'=>'required|numeric'
    ];
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function inventory()
    {
        return $this->hasOne('Controlpad\Inventory\InventoryModel','item_id');
    }
    
    public function products()
    {
        return $this->belongsToMany('Controlpad\Inventory\ProductModel',$this->table_prefix.'item_products','product_id','item_id');    
    }
     public function receives()
    {
        return $this->hasMany('Controlpad\Inventory\ReceiveModel','item_id');
    }
    
}
?>
