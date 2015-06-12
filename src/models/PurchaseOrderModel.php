<?php
namespace Controlpad\Inventory;

class PurchaseOrderModel extends MainModel {
    protected $table = 'purchaseorders';
    
    public static $rules = [
    // 'title' => 'required'
    ];
    
	

    protected $fillable = array();
    protected $guarded = array();
    
    protected $hidden =['user'];
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function vendor()
    {
        return $this->belongsTo('Controlpad\Inventory\VendorModel','vendor_id'); 
    }
    
    public function polines()
    {
        return $this->hasMany('Controlpad\Inventory\PoLineModel','purchaseorder_id');
    }

	
 	public function receives()
    {
        return $this->hasMany('Controlpad\Inventory\ReceiveModel','purchaseorder_id');
    }
	
	protected $appends =['total_receive','total_order','total_amount'];
	
	public function getTotalReceiveAttribute()
	{
		//return 0;
		$total = 0;
		if(count($this->receives)>0)
		{
			foreach($this->receives as $po)
			{
				$total = $total + $po->actual_quantity;
			}
			return $total;
		}else
			return 0;
	}
	public function getTotalOrderAttribute()
	{
		//return 0;
		$total = 0;
		if(count($this->polines)>0)
		{
			foreach($this->polines as $po)
			{
				$total = $total + ($po->qty);
			}
			return $total;
		}else
			return 0;
	}

	public function getTotalAmountAttribute()
	{
		//return 0;
		$total = 0;
		if(count($this->receives)>0)
		{
			foreach($this->receives as $po)
			{
				$total = $total + ($po->actual_price * $po->actual_quantity);
			}
			return $total;
		}else
			return 0;
	}
        
       
    
    public function user()
    {
        return $this->belongsTo('User','user_id');
}

    public function getUserNameAttribute(){
    	if(!is_null($this->user))
            return $this->user->first_name." ".$this->user->last_name;
        else
            return "";
}
    
}
?>
