<?php

use Illuminate\Http\Response;

class ElectronicInvoiceTest extends TestCase
{
    public function testReceiveNfe()
    {
        $header = [
            'Content-Type'=>'application/json',
            'x-api-id'=>'f96ae22f7c5d74fa4d78e764563d52811570588e',
            'x-api-key'=>'cc79ee9464257c9e1901703e04ac9f86b0f387c2'
        ];
        $this->post('nfe/receive',[],$header);
        $this->seeStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function testShowCategory()
    {
        $nfe = \App\ElectronicInvoice::first();
        $this->get('nfe/'.$nfe->key);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonContains([
            'key' => $nfe->key,
            'xml' => $nfe->xml,
        ]);
    }
}
