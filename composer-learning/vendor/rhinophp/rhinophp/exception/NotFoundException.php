<?php

/**
 */

namespace rhinophp\rhinophp\exception;


/**
 * Class NotFoundException
 *
 */
class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}