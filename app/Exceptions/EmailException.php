<?php 

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class EmailException extends Exception
{
    public function getJsonMessage()
    {
        return new Response(["message" => $this->getMessage()], 400);
    }

}