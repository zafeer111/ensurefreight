<?php

namespace App\Repositories\Quotation;

interface IQuotation
{
    public function index($userId);
    public function show($userId, $id);
    public function store(array $data);
    public function updateStatus($quotationId, $lineItemId, $status);
    public function sendQuoteEmail($inquiry);
}
