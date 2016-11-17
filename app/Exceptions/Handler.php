<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void 
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if (getenv('APP_DEBUG') == 'true')
        {
            //TRATANDO EXCEPTION  DE ERRO DE TOKEN EM DEV
            if ($e instanceof TokenMismatchException)
            {
                return response()->json([  'message' => "Token não recebido" ], 400);
            }

            return parent::render($request, $e);
        }

        if ($e instanceof ModelNotFoundException)
        {
            Log::error( $e->getMessage() ); 
            return redirect(route('404'));
        }

        if($this->isHttpException($e))
        {

         //retornando página de erro
          return redirect(route('404'));

        } else {

           return parent::render($request, $e);

        }
    }
}
