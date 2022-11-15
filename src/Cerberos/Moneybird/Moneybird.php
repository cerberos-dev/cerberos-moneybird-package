<?php

namespace Cerberos\Moneybird;

use Cerberos\Moneybird\Entities\Administration;
use Cerberos\Moneybird\Entities\Contact;
use Cerberos\Moneybird\Entities\ContactCustomField;
use Cerberos\Moneybird\Entities\CustomField;
use Cerberos\Moneybird\Entities\DocumentStyle;
use Cerberos\Moneybird\Entities\Estimate;
use Cerberos\Moneybird\Entities\ExternalSalesInvoice;
use Cerberos\Moneybird\Entities\ExternalSalesInvoiceDetail;
use Cerberos\Moneybird\Entities\ExternalSalesInvoicePayment;
use Cerberos\Moneybird\Entities\FinancialAccount;
use Cerberos\Moneybird\Entities\FinancialMutation;
use Cerberos\Moneybird\Entities\FinancialStatement;
use Cerberos\Moneybird\Entities\GeneralDocument;
use Cerberos\Moneybird\Entities\GeneralJournalDocument;
use Cerberos\Moneybird\Entities\GeneralJournalDocumentEntry;
use Cerberos\Moneybird\Entities\Identity;
use Cerberos\Moneybird\Entities\ImportMapping;
use Cerberos\Moneybird\Entities\LedgerAccount;
use Cerberos\Moneybird\Entities\Note;
use Cerberos\Moneybird\Entities\Product;
use Cerberos\Moneybird\Entities\Project;
use Cerberos\Moneybird\Entities\PurchaseInvoice;
use Cerberos\Moneybird\Entities\PurchaseInvoiceDetail;
use Cerberos\Moneybird\Entities\PurchaseInvoicePayment;
use Cerberos\Moneybird\Entities\Receipt;
use Cerberos\Moneybird\Entities\ReceiptDetail;
use Cerberos\Moneybird\Entities\ReceiptPayment;
use Cerberos\Moneybird\Entities\RecurringSalesInvoice;
use Cerberos\Moneybird\Entities\RecurringSalesInvoiceCustomField;
use Cerberos\Moneybird\Entities\RecurringSalesInvoiceDetail;
use Cerberos\Moneybird\Entities\SalesInvoice;
use Cerberos\Moneybird\Entities\SalesInvoiceCustomField;
use Cerberos\Moneybird\Entities\SalesInvoiceDetail;
use Cerberos\Moneybird\Entities\SalesInvoicePayment;
use Cerberos\Moneybird\Entities\SalesInvoiceReminder;
use Cerberos\Moneybird\Entities\Subscription;
use Cerberos\Moneybird\Entities\TaxRate;
use Cerberos\Moneybird\Entities\TimeEntry;
use Cerberos\Moneybird\Entities\TypelessDocument;
use Cerberos\Moneybird\Entities\User;
use Cerberos\Moneybird\Entities\Webhook;
use Cerberos\Moneybird\Entities\Workflow;

class Moneybird
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $attributes
     *
     * @return Administration
     */
    public function administration($attributes = [])
    {
        return new Administration(
            $this->connection->withoutAdministrationId(),
            $attributes
        );
    }

    /**
     * @param $attributes
     *
     * @return Contact
     */
    public function contact($attributes = [])
    {
        return new Contact($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ContactCustomField
     */
    public function contactCustomField($attributes = [])
    {
        return new ContactCustomField($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Note
     */
    public function note($attributes = [])
    {
        return new Note($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return CustomField
     */
    public function customField($attributes = [])
    {
        return new CustomField($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return DocumentStyle
     */
    public function documentStyle($attributes = [])
    {
        return new DocumentStyle($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Estimate
     */
    public function estimate($attributes = [])
    {
        return new Estimate($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ExternalSalesInvoice
     */
    public function externalSalesInvoice($attributes = [])
    {
        return new ExternalSalesInvoice($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ExternalSalesInvoiceDetail
     */
    public function externalSalesInvoiceDetail($attributes = [])
    {
        return new ExternalSalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ExternalSalesInvoicePayment
     */
    public function externalSalesInvoicePayment($attributes = [])
    {
        return new ExternalSalesInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return FinancialAccount
     */
    public function financialAccount($attributes = [])
    {
        return new FinancialAccount($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return FinancialMutation
     */
    public function financialMutation($attributes = [])
    {
        return new FinancialMutation($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return FinancialStatement
     */
    public function financialStatement($attributes = [])
    {
        return new FinancialStatement($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return GeneralDocument
     */
    public function generalDocument($attributes = [])
    {
        return new GeneralDocument($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return GeneralJournalDocument
     */
    public function generalJournalDocument($attributes = [])
    {
        return new GeneralJournalDocument($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return GeneralJournalDocumentEntry
     */
    public function generalJournalDocumentEntry($attributes = [])
    {
        return new GeneralJournalDocumentEntry($this->connection, $attributes);
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param $attributes
     *
     * @return Identity
     */
    public function identity($attributes = [])
    {
        return new Identity($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ImportMapping
     */
    public function importMapping($attributes = [])
    {
        return new ImportMapping($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return LedgerAccount
     */
    public function ledgerAccount($attributes = [])
    {
        return new LedgerAccount($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Product
     */
    public function product($attributes = [])
    {
        return new Product($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Project
     */
    public function project($attributes = [])
    {
        return new Project($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return PurchaseInvoice
     */
    public function purchaseInvoice($attributes = [])
    {
        return new PurchaseInvoice($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return PurchaseInvoiceDetail
     */
    public function purchaseInvoiceDetail($attributes = [])
    {
        return new PurchaseInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return PurchaseInvoicePayment
     */
    public function purchaseInvoicePayment($attributes = [])
    {
        return new PurchaseInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Receipt
     */
    public function receipt($attributes = [])
    {
        return new Receipt($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ReceiptDetail
     */
    public function receiptDetail($attributes = [])
    {
        return new ReceiptDetail($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return ReceiptPayment
     */
    public function receiptPayment($attributes = [])
    {
        return new ReceiptPayment($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return RecurringSalesInvoice
     */
    public function recurringSalesInvoice($attributes = [])
    {
        return new RecurringSalesInvoice($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return RecurringSalesInvoiceCustomField
     */
    public function recurringSalesInvoiceCustomField($attributes = [])
    {
        return new RecurringSalesInvoiceCustomField($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return RecurringSalesInvoiceDetail
     */
    public function recurringSalesInvoiceDetail($attributes = [])
    {
        return new RecurringSalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return SalesInvoice
     */
    public function salesInvoice($attributes = [])
    {
        return new SalesInvoice($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return SalesInvoiceCustomField
     */
    public function salesInvoiceCustomField($attributes = [])
    {
        return new SalesInvoiceCustomField($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return SalesInvoiceDetail
     */
    public function salesInvoiceDetail($attributes = [])
    {
        return new SalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return SalesInvoicePayment
     */
    public function salesInvoicePayment($attributes = [])
    {
        return new SalesInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return SalesInvoiceReminder
     */
    public function salesInvoiceReminder($attributes = [])
    {
        return new SalesInvoiceReminder($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return TaxRate
     */
    public function taxRate($attributes = [])
    {
        return new TaxRate($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return TimeEntry
     */
    public function timeEntry($attributes = [])
    {
        return new TimeEntry($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return TypelessDocument
     */
    public function typelessDocument($attributes = [])
    {
        return new TypelessDocument($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return User
     */
    public function user($attributes = [])
    {
        return new User($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Webhook
     */
    public function webhook($attributes = [])
    {
        return new Webhook($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Workflow
     */
    public function workflow($attributes = [])
    {
        return new Workflow($this->connection, $attributes);
    }

    /**
     * @param $attributes
     *
     * @return Subscription
     */
    public function subscription($attributes = [])
    {
        return new Subscription($this->connection, $attributes);
    }
}
