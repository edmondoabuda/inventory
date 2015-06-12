<?php namespace Controlpad\Inventory\Facades;

use Illuminate\Support\Facades\Facade;

class Inventory extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'inventory'; }

}

?>