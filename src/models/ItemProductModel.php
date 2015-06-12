<?php
namespace Controlpad\Inventory;

class ItemProductModel extends MainModel {
    protected $table = 'item_products';
    
    public static $rules = [
    // 'title' => 'required'
    ];
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function items()
    {
        return $this->belongsTo('Controlpad\Inventory\ItemModel','item_id');
    }
	
	  public function product()
    {
        return $this->belongsTo('Controlpad\Inventory\ProductModel','product_id');
    }
}
?>

