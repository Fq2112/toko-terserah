<?php


namespace App\Support\Facades;


use Illuminate\Support\Facades\Facade;

class Rating extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Rating';
    }
}
