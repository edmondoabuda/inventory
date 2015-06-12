<?php
namespace Controlpad\Inventory;

class PoLineModel extends MainModel {
    protected $table = 'po_lines';
    
    public static $rules = [
    // 'title' => 'required'
    ];
    
    protected $fillable = array();
    protected $guarded = array();
    
    public function __construct($attributes=array()){
        parent::__construct($attributes,$this->table);
    }
	
	protected $appends = ['computed_qty','total_receive'];
    
    ##############################################################################################
    # Relationships
    ##############################################################################################
    
    public function item()
    {
        return $this->belongsTo('Controlpad\Inventory\ItemModel','item_id');    
    }

    public function receives()
    {
        return $this->hasMany('Controlpad\Inventory\ReceiveModel','purchaseorder_id');
    }
    
    public function vendor()
    {
        return $this->belongsTo('Controlpad\Inventory\VendorModel','vendor_id');
    }
	
	public function getComputedQtyAttribute()
	{
		
		if(count($this->receives)==0)
			return $this->qty;			
		else
		{	
			$q = $this->receives->last();					
			return  $q->remaining_balance;
		}
				
	}

    public function getTotalReceiveAttribute()
    {
        
        if(count($this->receives)==0)
            return 0;          
        else
        {   
            $total= 0;
            foreach ($this->receives as $receive) {
               $total = $total + $receive->actual_quantity;
            }
                             
            return  $total;
        }
                
    }
        public function scopeActiveItem($query)
        {       
            return $query->whereHas('item',function($item){                
                return $item->whereHas('receives',function($receives){
                     $receives->where('remaining_balance',0);
                });
            });         
        } 
}
?>

