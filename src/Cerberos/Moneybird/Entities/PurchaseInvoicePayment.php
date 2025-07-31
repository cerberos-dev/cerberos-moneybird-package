<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Entities\Generic\InvoicePayment;
use Cerberos\Moneybird\Exceptions\ApiException;
use Cerberos\Moneybird\Exceptions\TooManyRequestsException;
use GuzzleHttp\Exception\GuzzleException;

class PurchaseInvoicePayment extends InvoicePayment
{
    /**
     * Delete the current purchase invoice payment.
     *
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     * @return mixed
     *
     */
    public function delete(): mixed
    {
        return $this->connection()->delete('/documents/purchase_invoices/' . urlencode($this->invoice_id) . '/payments/' . urlencode($this->id));
    }
}
