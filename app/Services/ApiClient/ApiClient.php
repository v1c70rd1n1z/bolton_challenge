<?php


namespace App\Services\ApiClient;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiClient implements ApiClientInterface
{
    private $baseUri;
    private $options;

    public function setBaseUri($baseUri): ApiClient
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    public function setOptions($options): ApiClient
    {
        $this->options = $options;

        return $this;
    }

    public function getClient(): Client
    {
        return new Client(['base_uri' => $this->baseUri]);
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getBodyContents(ResponseInterface $response)
    {
        return $response->getBody()->getContents();
    }

    public function getBodyContentsToJson(ResponseInterface $response)
    {
        return json_decode($this->getBodyContents($response));
    }
}
