<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Exceptions\TooManyRequestsException;
use Cerberos\Moneybird\Entities\Generic\InvoicePayment;
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
