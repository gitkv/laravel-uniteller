<?php

namespace gitkv\Uniteller\Facade;


use gitkv\Uniteller\UnitellerBase;
use Illuminate\Support\Facades\Facade as CoreFacade;

class Uniteller extends CoreFacade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return UnitellerBase::class;
    }
}
