<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class PersistenceException extends Exception
{
    public function getJsonMessage()
    {
        return new Response(["message" => $this->getMessage()], 400);
    }

}