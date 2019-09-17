<?php


namespace App\Services\ElectronicInvoiceService;

use App\Models\ElectronicInvoice;
use Illuminate\Database\Eloquent\Collection;

class ListsResponseFactory
{
    /**
     * @param Collection $electronicInvoiceList
     * @return array
     */
    public function make(Collection $electronicInvoiceList)
    {
        $response = [];
        /** @var ElectronicInvoice $electronicInvoice */
        foreach ($electronicInvoiceList as $electronicInvoice) {
            array_push($response, ['key'=>$electronicInvoice->key]);
        }
        return $response;
    }
}
