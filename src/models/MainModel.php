<?php

namespace Controlpad\Inventory;

use \Illuminate\Database\Eloquent\Model as Eloquent;

class MainModel extends Eloquent {
    protected $table = 'mains';
    protected $table_prefix = ""; 
    
    public static $rules = [
    // 'title' => 'required'
    ];
    
    protected $fillable = array();
    protected $guarded = array();
    protected $attributes = array();
    
    public function __construct($attributes=array(),$table = "mains"){
        parent::__construct($attributes);
        $this->table_prefix = \Config::get('inventory::database.connections.controlpad-inventory.prefix'); 
        $this->table = $this->table_prefix.$table;
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
}