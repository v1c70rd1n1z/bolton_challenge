<?php


namespace App\Services\ElectronicInvoiceService;

use App\Models\ElectronicInvoice;

class ShowResponseFactory
{
    public function make(ElectronicInvoice $electronicInvoice): ShowResponse
    {
        return new ShowResponse($electronicInvoice->key, $electronicInvoice->value);
    }
}
