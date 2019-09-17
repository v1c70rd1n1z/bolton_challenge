<?php


namespace App\Services\ApiClient;

class ApiClientResponseStatus
{
    /** @var int */
    private $code;
    /** @var string */
    private $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}
