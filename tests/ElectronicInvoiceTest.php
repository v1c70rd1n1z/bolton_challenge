<?php

use App\Models\ElectronicInvoice;
use App\Services\ElectronicInvoiceService\ShowResponse;
use Illuminate\Http\Response;

class ElectronicInvoiceTest extends TestCase
{
    public function testReceiveElectronicInvoice()
    {
        $this->post('nfe/receive');
        $this->seeStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function testListElectronicInvoice()
    {
        $nfe = ElectronicInvoice::first();
        $this->get('nfe/'.$nfe->key);
        $this->seeStatusCode(Response::HTTP_OK);
        $showResponse = new ShowResponse($nfe->key, $nfe->value);
        $this->seeJsonContains([
            'key' => $showResponse->getKey(),
            'value' => $showResponse->getValue(),
        ]);
    }

    public function testShowElectronicInvoice()
    {
        $this->get('nfe/');
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([['key']]);
    }
}
