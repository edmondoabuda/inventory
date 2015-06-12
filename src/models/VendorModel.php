<?php

namespace Controlpad\Inventory;

class VendorModel extends MainModel {
    protected $table = 'vendors';
    
    public static $rules = [
        'name' => 'required',
        'phone' => 'required|numeric|digits:10',        
        'email' => 'email'
    ];
    public static $custom_name = [
        'phone' => 'Phone',
        'name' => 'Name',
        'email' => 'Email'
    ];
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }

    public function address()
    {
        return $this->morphOne('Address', 'addressable');
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
}
?>
