<?php


namespace App\Services\ElectronicInvoiceService;

class ShowResponse
{
    /** @var string */
    private $key;
    /** @var string */
    private $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = 'R$ ' . number_format($value, 2, ',', '.');
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
