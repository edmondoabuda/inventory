<?php

namespace Controlpad\Inventory;

class OrderLineModel extends MainModel {
    protected $table = 'orderlines';
    
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
    
   
    
  
    
}
?>
