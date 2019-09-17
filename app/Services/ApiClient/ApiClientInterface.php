<?php


namespace App\Services\ApiClient;

use GuzzleHttp\Client;

interface ApiClientInterface
{
    public function getClient(): Client;
    public function getBaseUri(): string;
    public function getOptions(): array;
}
