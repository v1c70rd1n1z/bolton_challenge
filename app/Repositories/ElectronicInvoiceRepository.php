<?php


namespace App\Repositories;

use App\Models\ElectronicInvoice;

class ElectronicInvoiceRepository implements ElectronicInvoiceInterface
{
    /** @var ElectronicInvoice */
    private $model;

    public function __construct(ElectronicInvoice $electronicInvoice)
    {
        $this->model = $electronicInvoice;
    }

    public function getFirst(string $key)
    {
        return ElectronicInvoice::where('key', $key)->first();
    }

    public function list()
    {
        return $this->model->all(['key']);
    }

    public function show($key)
    {
        return ElectronicInvoice::where('key', $key)->firstOrFail();
    }
}
