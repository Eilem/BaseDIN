<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class PatternException extends Exception
{
    static function getJsonMessage()
    {
        return new Response(['message' => 'Desculpe, ocorreu algum erro, por favor tente novamente.'], 400);
    }

}

