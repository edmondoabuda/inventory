<?php

namespace Controlpad\Inventory;

class OrderModel extends MainModel {
    protected $table = 'orders';
    
    public static $rules = [
    
    ];
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
   
    public function orderline()
    {
        return $this->hasMany('Controlpad\Inventory\OrderLineModel','order_id');
    }
  
    
}
?>
