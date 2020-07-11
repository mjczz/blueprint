<?php
/**
 * Created by czz.
 * User: czz
 * Date: 2020/6/27
 * Time: 14:10
 */

namespace App\Exceptions;

use Throwable;

class ApiCommonException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->message = $message;

        parent::__construct($message, $code, $previous);
    }

}
