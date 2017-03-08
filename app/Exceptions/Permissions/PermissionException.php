<?php
namespace App\Exceptions\Permissions;

use Exception;

class PermissionException extends Exception
{
    public function __construct($message = "No tiene permiso para realizar esta operacion", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}