<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Entities\Generic\InvoicePayment;
use Cerberos\Moneybird\Exceptions\ApiException;

/**
 * Class SalesInvoicePayment.
 */
class PurchaseInvoicePayment extends InvoicePayment
{
    /**
     * Delete the current purchase invoice payment.
     *
     * @return mixed
     *
     * @throws ApiException
     */
    public function delete()
    {
        return $this->connection()->delete('/documents/purchase_invoices/' . urlencode($this->invoice_id) . '/payments/' . urlencode($this->id));
    }
}
