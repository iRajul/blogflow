<?php

namespace irajul\Blogflow\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \irajul\Blogflow\Blogflow
 */
class Blogflow extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \irajul\Blogflow\Blogflow::class;
    }
}
