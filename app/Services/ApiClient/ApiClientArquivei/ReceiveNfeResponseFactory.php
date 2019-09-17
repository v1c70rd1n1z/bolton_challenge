<?php


namespace App\Services\ApiClient\ApiClientArquivei;

use App\Services\ApiClient\ApiClientResponseStatus;
use Illuminate\Support\Collection;
use stdClass;

class ReceiveNfeResponseFactory
{
    public function make(stdClass $response): ReceiveNfeResponse
    {
        $responseStatus = $this->getResponseStatus($response->status);
        $responseData = $this->getResponseData($response->data);
        return new ReceiveNfeResponse($responseStatus, $responseData);
    }

    private function getResponseStatus(stdClass $status)
    {
        return new ApiClientResponseStatus($status->code, $status->message);
    }

    /**
     * @param array $data
     * @return Collection|ReceiveNfeResponseData[]
     */
    private function getResponseData(array $data)
    {
        if (count($data) === 0) {
            return new Collection();
        }

        $response = new Collection();

        foreach ($data as $nfe) {
            $receiveNfeResponseData = new ReceiveNfeResponseData($nfe->access_key, $nfe->xml);
            $response->add($receiveNfeResponseData);
        }

        return $response;
    }
}
