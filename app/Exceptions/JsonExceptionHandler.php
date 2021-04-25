<?php

namespace App\Exceptions;

use Exception;
use \Illuminate\Http\JsonResponse;

class JsonExceptionHandler extends Exception
{
    private $exceptionCause;

    public function __construct(JsonResponse $exceptionCause)
    {
        $this->exceptionCause = $exceptionCause;
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return $this->exceptionCause;
    }
}
