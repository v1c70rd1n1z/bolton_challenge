<?php


namespace App\Services;

use App\Exceptions\ApiClientArquiveiEnvironmentVariableMissingException;
use App\Exceptions\ApiClientArquiveiException;
use App\Exceptions\ApiClientArquiveiResponseStructureException;
use App\Models\ElectronicInvoice;
use App\Repositories\ElectronicInvoiceInterface;
use App\Services\ApiClient\ApiClientArquivei;
use App\Services\ElectronicInvoiceService\ListsResponseFactory;
use App\Services\ElectronicInvoiceService\ShowResponse;
use App\Services\ElectronicInvoiceService\ShowResponseFactory;
use Illuminate\Support\Collection;
use Nathanmac\Utilities\Parser\Exceptions\ParserException;
use Nathanmac\Utilities\Parser\Parser;

class ElectronicInvoiceService
{
    /** @var ApiClientArquivei */
    private $apiClient;

    private $electronicInvoiceRepository;

    public function __construct(ElectronicInvoiceInterface $electronicInvoiceRepository)
    {
        $this->electronicInvoiceRepository = $electronicInvoiceRepository;
    }

    /**
     * @throws ApiClientArquiveiException
     * @throws ApiClientArquiveiResponseStructureException
     * @throws ParserException
     * @throws ApiClientArquiveiEnvironmentVariableMissingException
     */
    public function receive()
    {
        $this->apiClient = new ApiClientArquivei();

        $response = $this->apiClient->receiveNfe();

        $this->saveNfeResponse($response->getData());
    }

    /**
     * @param ApiClientArquivei\ReceiveNfeResponseData[]|Collection $receiveNfeResponseData
     * @throws ParserException
     */
    private function saveNfeResponse(Collection $receiveNfeResponseData)
    {
        foreach ($receiveNfeResponseData as $nfeResponse) {
            $nfe = $this->getNfeObject($nfeResponse);

            $nfe->key = $nfeResponse->getAccessKey();
            $nfe->value = $this->getTotalValue(base64_decode($nfeResponse->getXml()));

            $nfe->save();
        }
    }

    /**
     * @param string $xmlContent
     * @return mixed
     * @throws ParserException
     */
    private function getTotalValue(string $xmlContent): float
    {
        $parser = new Parser();
        $parsed = $parser->xml($xmlContent);

        if (isset($parsed['NFe'])) {
            return (float) $parsed['NFe']['infNFe']['total']['ICMSTot']['vNF'];
        }

        return (float) $parsed['infNFe']['total']['ICMSTot']['vNF'];
    }

    private function getNfeObject(ApiClientArquivei\ReceiveNfeResponseData $nfeResponse)
    {
        $nfeOnDatabase = $this->electronicInvoiceRepository->getFirst($nfeResponse->getAccessKey());

        if (null === $nfeOnDatabase) {
            return new ElectronicInvoice();
        }

        return $nfeOnDatabase;
    }

    public function lists(): array
    {
        $list = $this->electronicInvoiceRepository->list();

        $factory = new ListsResponseFactory();

        return $factory->make($list);
    }

    public function show($key): ShowResponse
    {
        $item = $this->electronicInvoiceRepository->show($key);

        $factory = new ShowResponseFactory();

        return $factory->make($item);
    }
}
