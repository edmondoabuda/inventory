<?php

namespace Controlpad\Inventory;

class ReceiveModel extends MainModel {
    protected $table = 'receives';
    
    public static $rules = [
        'actual_price' => 'required|numeric',
        'receipt_number' => 'required'
    ];   
    
    
    protected $fillable = array();
    protected $guarded = array();

    protected $appends =['user_name'];
    protected $hidden =['user'];
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################    
    
   /* 
    public function products()
    {
        return $this->belongsToMany('Controlpad\Inventory\ProductModel',$this->table_prefix.'item_products','product_id','item_id');    
    }
	
	public function purchaseorder()
	{
		return $this->belongsTo('Controlpad\Inventory\PurchaseOrderModel',$this->table_prefix.'purchaseorders','purchaseorder_id','id');
	}
	*/
    public function user()
    {
        return $this->hasOne('User','user_id');
    }

    public function getUserNameAttribute(){
        if(!is_null($this->user))
            return "$this->user->first_name $this->user->last_name";
        else
            return "";
    }

	public function item()
    {
        return $this->belongsTo('Controlpad\Inventory\ItemModel','item_id');    
    }

	public  $custom_rules = [
                    'actual_price' => 'required|numeric'
		];
}
?>
