<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 30.03.2018
 * Time: 18:33
 */

namespace core\Exception;

use Throwable;

class ModelException extends \Exception
{
    public function __construct($message = "Error Code", $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}