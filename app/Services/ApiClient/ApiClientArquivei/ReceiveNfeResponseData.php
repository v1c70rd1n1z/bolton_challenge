<?php


namespace App\Services\ApiClient\ApiClientArquivei;

class ReceiveNfeResponseData
{
    /** @var string */
    private $accessKey;

    /** @var string */
    private $xml;

    public function __construct(string $accessKey, string $xml)
    {
        $this->accessKey = $accessKey;
        $this->xml = $xml;
    }

    /**
     * @return string
     */
    public function getAccessKey(): string
    {
        return $this->accessKey;
    }

    /**
     * @return string
     */
    public function getXml(): string
    {
        return $this->xml;
    }
}
