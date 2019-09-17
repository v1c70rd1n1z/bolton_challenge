<?php


namespace App\Exceptions;

use Illuminate\Http\Response;
use Exception;

class ElectronicInvoiceListsException extends Exception
{
    protected $message = 'Something went wrong when trying to parse Electronic Invoice list.';

    public function report()
    {
        \Log::error($this->getMessage() . PHP_EOL . $this->getTraceAsString());
    }

    public function render()
    {
        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, $this->getMessage());
    }
}
