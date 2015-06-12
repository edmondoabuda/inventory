<?php namespace Controlpad\Inventory;

class OrdersController extends BaseController {

	protected $route_path = "";
    protected $view_path = "";
    protected $item_basepath = "";
    
    
    public function __construct(){
        $this->route_path = \Config::get('inventory::config.route.orders.path');
        $this->view_path = \Config::get('inventory::config.view_path.orders');
        $this->item_basepath = \Config::get('inventory::config.route.orders.path');
    }

    public function getAllOrders()
    {
    	return OrderModel::all();
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		
        $basepath = $this->route_path;
        return \View::make($this->package_name.'::'.$this->view_path.'.index',compact('main','basepath'));   
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
