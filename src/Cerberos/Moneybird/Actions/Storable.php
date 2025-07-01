<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Entities\Contact;
use Cerberos\Moneybird\Entities\Estimate;
use Cerberos\Moneybird\Entities\ExternalSalesInvoice;
use Cerberos\Moneybird\Entities\FinancialStatement;
use Cerberos\Moneybird\Entities\GeneralDocument;
use Cerberos\Moneybird\Entities\GeneralJournalDocument;
use Cerberos\Moneybird\Entities\Identity;
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
use Cerberos\Moneybird\Entities\Webhook;
use GuzzleHttp\Exception\GuzzleException;

trait Storable
{
    use BaseTrait;

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @return bool|mixed
     */
    public function save(): mixed
    {
        if ($this->exists()) {
            return $this->update();
        }

        return $this->insert();
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @return Contact|Estimate|ExternalSalesInvoice|FinancialStatement|GeneralDocument|GeneralJournalDocument|Identity|LedgerAccount|Product|Project|PurchaseInvoice|Receipt|RecurringSalesInvoice|SalesInvoice|Subscription|TimeEntry|TypelessDocument|Webhook
     */
    public function insert(): Subscription | TypelessDocument | Estimate | PurchaseInvoice | GeneralDocument | RecurringSalesInvoice | FinancialStatement | Identity | SalesInvoice | ExternalSalesInvoice | GeneralJournalDocument | LedgerAccount | Contact | TimeEntry | Receipt | Product | Project | Webhook
    {
        $result = $this->connection()->post($this->getEndpoint(), $this->jsonWithNamespace());

        if (method_exists($this, 'clearDirty')) {
            $this->clearDirty();
        }

        return $this->selfFromResponse($result);
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @return bool|Contact|Estimate|ExternalSalesInvoice|FinancialStatement|GeneralDocument|GeneralJournalDocument|Identity|LedgerAccount|Product|Project|PurchaseInvoice|Receipt|RecurringSalesInvoice|SalesInvoice|Subscription|TimeEntry|TypelessDocument|Webhook
     */
    public function update(): Subscription | TypelessDocument | Estimate | PurchaseInvoice | GeneralDocument | RecurringSalesInvoice | FinancialStatement | Identity | SalesInvoice | bool | ExternalSalesInvoice | GeneralJournalDocument | LedgerAccount | Contact | TimeEntry | Receipt | Product | Project | Webhook
    {
        $result = $this->connection()->patch($this->getEndpoint() . '/' . urlencode($this->id), $this->jsonWithNamespace());

        if ($result === 200) {
            if (method_exists($this, 'clearDirty')) {
                $this->clearDirty();
            }

            return true;
        }

        return $this->selfFromResponse($result);
    }
}
