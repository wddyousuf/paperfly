<?php
namespace Wddyousuf\Paperfly\Facades;
use Illuminate\Support\Facades\Facade;

class PaperflyCourier extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PaperflyCourier';
    }
}
