<?php

namespace Controlpad\Inventory;

class TransferModel extends MainModel {
    protected $table = 'transfers';
    
    public static $rules = [
        'item_id' => 'required',
        'qty' => 'required',
        'warehouse_id_from' => 'required|min:1',
        'warehouse_id_to' => 'required|min:1'
    ];

    protected $appends =['warehouse_from_name','warehouse_to_name', 'item_name'];
    
    protected $fillable = array();
    protected $guarded = array();

    protected $hidden = array('warehouse_from', 'warehouse_to', 'item');
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }

    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    public function warehouse_from()
    {
        return $this->belongsTo("Controlpad\Inventory\WarehouseModel",'warehouse_id_from');
    }
    
    public function warehouse_to()
    {
        return $this->belongsTo("Controlpad\Inventory\WarehouseModel",'warehouse_id_to');
    }

    public function item()
    {
        return $this->belongsTo("Controlpad\Inventory\ItemModel",'item_id');
    }

    public function getWarehouseFromNameAttribute()
    {
        if(!is_null($this->warehouse_from))
            return $this->warehouse_from->name;
        else
            return "";
    }

     public function getWarehouseToNameAttribute()
    {
        if(!is_null($this->warehouse_to))
            return $this->warehouse_to->name;
        else
            return "";
    }

    public function getItemNameAttribute()
    {
        if(!is_null($this->item))
            return $this->item->name;
        else
            return "";
    }
    
    
}
?>
