<?php namespace  Controlpad\InvMethod;

use Illuminate\Support\Facades\Facade;

class InvMethodFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'invmethod'; }

}