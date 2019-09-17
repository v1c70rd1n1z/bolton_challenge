<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ApiClientArquiveiException extends Exception
{
    protected $message = 'Something went wrong on ApiClientArquivei.';

    public function report()
    {
        \Log::error($this->getMessage() . PHP_EOL . $this->getTraceAsString());
    }

    public function render()
    {
        return abort(Response::HTTP_BAD_REQUEST, $this->getMessage());
    }
}
