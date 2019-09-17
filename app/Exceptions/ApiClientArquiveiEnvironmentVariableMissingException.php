<?php


namespace App\Exceptions;

use Illuminate\Http\Response;
use Exception;

class ApiClientArquiveiEnvironmentVariableMissingException extends Exception
{
    protected $message = 'One of ArquiveiApi environment variables is missing.';

    public function report()
    {
        \Log::error($this->getMessage() . PHP_EOL . $this->getTraceAsString());
    }

    public function render()
    {
        return abort(Response::HTTP_UNPROCESSABLE_ENTITY, $this->getMessage());
    }
}
