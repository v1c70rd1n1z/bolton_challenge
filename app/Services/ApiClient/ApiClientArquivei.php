<?php


namespace App\Services\ApiClient;

use App\Exceptions\ApiClientArquiveiEnvironmentVariableMissingException;
use App\Exceptions\ApiClientArquiveiException;
use App\Exceptions\ApiClientArquiveiResponseStructureException;
use App\Services\ApiClient\ApiClientArquivei\ReceiveNfeResponse;
use App\Services\ApiClient\ApiClientArquivei\ReceiveNfeResponseFactory;
use Illuminate\Http\Response;

class ApiClientArquivei extends ApiClient
{
    /**
     * ApiClientArquivei constructor.
     * @throws ApiClientArquiveiEnvironmentVariableMissingException
     */
    public function __construct()
    {
        if (true === empty(env('ARQUIVEI_BASE_URI'))
            || true === empty(env('ARQUIVEI_X_API_ID'))
            || true === empty(env('ARQUIVEI_X_API_KEY'))) {
            throw new ApiClientArquiveiEnvironmentVariableMissingException();
        }

        $this->setBaseUri(env('ARQUIVEI_BASE_URI'));

        $headers = [
            'Content-Type' => 'application/json',
            'x-api-id' => env('ARQUIVEI_X_API_ID'),
            'x-api-key' => env('ARQUIVEI_X_API_KEY'),
        ];
        $this->setOptions(['http_errors' => false, 'headers' => $headers]);
    }

    /**
     * @return ReceiveNfeResponse
     * @throws ApiClientArquiveiException
     * @throws ApiClientArquiveiResponseStructureException
     */
    public function receiveNfe(): ReceiveNfeResponse
    {
        $response = $this->getClient()->get('nfe/received', $this->getOptions());

        $responseObject = $this->getBodyContentsToJson($response);
        if ($responseObject->status->code !== Response::HTTP_OK) {
            throw new ApiClientArquiveiException();
        }

        if (false === (isset($responseObject->data))) {
            throw new ApiClientArquiveiResponseStructureException();
        }

        return (new ReceiveNfeResponseFactory())->make($responseObject);
    }
}
