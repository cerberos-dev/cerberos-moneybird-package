<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Entities\Contact;
use Cerberos\Moneybird\Entities\Estimate;
use Cerberos\Moneybird\Entities\ExternalSalesInvoice;
use Cerberos\Moneybird\Entities\GeneralDocument;
use Cerberos\Moneybird\Entities\GeneralJournalDocument;
use Cerberos\Moneybird\Entities\Identity;
use Cerberos\Moneybird\Entities\ImportMapping;
use Cerberos\Moneybird\Entities\LedgerAccount;
use Cerberos\Moneybird\Entities\Product;
use Cerberos\Moneybird\Entities\Project;
use Cerberos\Moneybird\Entities\PurchaseInvoice;
use Cerberos\Moneybird\Entities\Receipt;
use Cerberos\Moneybird\Entities\RecurringSalesInvoice;
use Cerberos\Moneybird\Entities\SalesInvoice;
use Cerberos\Moneybird\Entities\Subscription;
use Cerberos\Moneybird\Entities\TimeEntry;
use Cerberos\Moneybird\Entities\TypelessDocument;
use GuzzleHttp\Exception\GuzzleException;

trait FindOne
{
    use BaseTrait;

    /**
     * @param int|string $id
     *
     * @return Contact|Estimate|ExternalSalesInvoice|GeneralDocument|GeneralJournalDocument|Identity|ImportMapping|LedgerAccount|Product|Project|PurchaseInvoice|Receipt|RecurringSalesInvoice|SalesInvoice|Subscription|TimeEntry|TypelessDocument
     * @throws ApiException
     * @throws GuzzleException
     */
    public function find(int|string $id): Subscription|TypelessDocument|Estimate|PurchaseInvoice|GeneralDocument|RecurringSalesInvoice|Identity|SalesInvoice|ExternalSalesInvoice|GeneralJournalDocument|LedgerAccount|Contact|TimeEntry|ImportMapping|Receipt|Product|Project
    {
        $result = $this->connection()->get($this->getEndpoint() . '/' . urlencode($id));

        return $this->makeFromResponse($result);
    }
}
