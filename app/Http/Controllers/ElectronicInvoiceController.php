<?php


namespace App\Http\Controllers;

use App\ElectronicInvoice;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class ElectronicInvoiceController
{
    public function receive()
    {
        $client = new Client(['base_uri' => 'https://sandbox-api.arquivei.com.br/v1/']);
        $headers = [
            'Content-Type' => 'application/json',
            'x-api-id' => 'f96ae22f7c5d74fa4d78e764563d52811570588e',
            'x-api-key' => 'cc79ee9464257c9e1901703e04ac9f86b0f387c2',
        ];
        $options = ['http_errors' => false, 'headers' => $headers];
        $response = $client->get('nfe/received', $options);
        $content = $response->getBody()->getContents();

        $responseObject = json_decode($content);

        if ($responseObject->status->code === Response::HTTP_OK) {
            foreach ($responseObject->data as $nfeResponse) {
                $nfe = $this->getNfeObject($nfeResponse);

                $nfe->key = $nfeResponse->access_key;
                $nfe->xml = base64_decode($nfeResponse->xml);

                $nfe->save();
            }
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }

    private function getNfeObject($nfeResponse)
    {
        $nfeOnDatabase = ElectronicInvoice::where('key', $nfeResponse->access_key)->first();

        if (null === $nfeOnDatabase) {
            return new ElectronicInvoice();
        }

        return $nfeOnDatabase;
    }

    public function lists()
    {
        return ElectronicInvoice::all();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function show($key)
    {
        return ElectronicInvoice::where('key', $key)->get();
    }
}
