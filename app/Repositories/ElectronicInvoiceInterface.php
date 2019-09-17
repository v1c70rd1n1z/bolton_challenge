<?php


namespace App\Repositories;

interface ElectronicInvoiceInterface
{
    public function getFirst(string $key);
    public function list();
    public function show(string $key);
}
