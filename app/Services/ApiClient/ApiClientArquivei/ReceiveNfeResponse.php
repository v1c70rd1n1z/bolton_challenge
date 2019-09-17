<?php


namespace App\Services\ApiClient\ApiClientArquivei;

use App\Services\ApiClient\ApiClientResponseStatus;
use Illuminate\Support\Collection;

class ReceiveNfeResponse
{
    /** @var ApiClientResponseStatus */
    private $status;

    /** @var ReceiveNfeResponseData[] */
    private $data;

    public function __construct(ApiClientResponseStatus $status, Collection $data)
    {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * @return ApiClientResponseStatus
     */
    public function getStatus(): ApiClientResponseStatus
    {
        return $this->status;
    }

    /**
     * @return ReceiveNfeResponseData[]|Collection
     */
    public function getData(): Collection
    {
        return $this->data;
    }
}
