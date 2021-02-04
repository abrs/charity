<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\Response;

class TokenExpiredException extends Exception
{

    protected $response;


    public function __construct($message = null, $code = null, Exception $previous = null)
    {
        parent::__construct($message ?? 'This token expiration date is dead!!', 0, $previous);

        $this->code = $code ?: 0;
    }

    public function response()
    {
        return $this->response;
    }

    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function toResponse()
    {
        return Response::deny($this->message, $this->code);
    }
}
