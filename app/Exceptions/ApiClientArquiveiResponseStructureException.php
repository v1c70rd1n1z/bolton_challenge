<?php


namespace App\Exceptions;

use Illuminate\Http\Response;
use Exception;

class ApiClientArquiveiResponseStructureException extends Exception
{
    protected $message = 'Something went wrong on ApiClientArquivei.';

    public function report()
    {
        \Log::error($this->getMessage() . PHP_EOL . $this->getTraceAsString());
    }

    public function render()
    {
        return abort(Response::HTTP_UNPROCESSABLE_ENTITY, $this->getMessage());
    }
}
