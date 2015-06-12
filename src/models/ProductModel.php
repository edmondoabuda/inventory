<?php
namespace Controlpad\Inventory;

class ProductModel extends MainModel {
    protected $table = 'products';
    
    public static $rules = [
        'name' => 'required',
        'price_retail' =>'required|numeric',
        'price_rep' => 'required|numeric',
        'price_cv' => 'required|numeric',
        'quantity' => 'required|numeric',
        'weight' => 'required|numeric',
        'volume' => 'required|numeric'
    ];

    public static $custom_name = 
                [
                        'name' => 'Name',
                        'price_retail' => 'Retail Price',
                        'price_rep' => "Rep Price",
                        'price_cv' => "CV Price",
                        'quantity' => "Quantity",
                        'weight' => "Weight",
                        'volume' => "Volume"
                ];
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    /*public function items()
    {
        return $this->belongsToMany('Controlpad\Inventory\ItemModel',$this->table_prefix.'item_products','product_id','item_id');    
    }*/
    
    public function productitems()
    {
        return $this->hasMany('Controlpad\Inventory\ItemProductModel','product_id');
    }
}
?>

