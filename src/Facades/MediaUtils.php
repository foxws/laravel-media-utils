<?php

namespace Foxws\MediaUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Foxws\MediaUtils\MediaUtils
 */
class MediaUtils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Foxws\MediaUtils\MediaUtils::class;
    }
}
