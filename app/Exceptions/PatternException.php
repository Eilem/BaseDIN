<?php 

namespace App\Exceptions;

use Exception;

class PatternException extends Exception
{
    static function getMessage()
    {
        return ['message' => 'Desculpe, ocorreu algum erro, por favor tente novamente.'];
    }

}

