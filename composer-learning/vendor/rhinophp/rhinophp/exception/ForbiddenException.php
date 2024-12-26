<?php

/**
 */

namespace rhinophp\rhinophp\exception;


use rhinophp\rhinophp\Application;

/**
 * Class ForbiddenException
 *
 */
class ForbiddenException extends \Exception
{
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}