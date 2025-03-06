<?php

namespace MarJose123\ZohoCliqAlert\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MarJose123\ZohoCliqAlert\ZohoCliqAlert
 */
class ZohoCliqAlert extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \MarJose123\ZohoCliqAlert\ZohoCliqAlert::class;
    }
}
