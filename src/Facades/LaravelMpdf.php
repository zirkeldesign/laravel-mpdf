<?php

namespace Meneses\LaravelMpdf\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelMpdf extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mpdf.wrapper';
    }
}
