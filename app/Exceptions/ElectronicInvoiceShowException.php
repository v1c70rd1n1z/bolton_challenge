<?php


namespace App\Exceptions;

use Illuminate\Http\Response;
use Exception;

class ElectronicInvoiceShowException extends Exception
{
    protected $message = 'Something went wrong when trying to to get an specific Electronic Invoice Response by a given key.';

    public function report()
    {
        \Log::error($this->getMessage() . PHP_EOL . $this->getTraceAsString());
    }

    public function render()
    {
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, $this->getMessage());
    }
}
