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
    protected Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $attributes
     *
     * @return Administration
     */
    public function administration(array $attributes = []): Administration
    {
        return new Administration(
            $this->connection->withoutAdministrationId(),
            $attributes
        );
    }

    /**
     * @param array $attributes
     *
     * @return Contact
     */
    public function contact(array $attributes = []): Contact
    {
        return new Contact($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ContactCustomField
     */
    public function contactCustomField(array $attributes = []): ContactCustomField
    {
        return new ContactCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Note
     */
    public function note(array $attributes = []): Note
    {
        return new Note($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return CustomField
     */
    public function customField(array $attributes = []): CustomField
    {
        return new CustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return DocumentStyle
     */
    public function documentStyle(array $attributes = []): DocumentStyle
    {
        return new DocumentStyle($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Estimate
     */
    public function estimate(array $attributes = []): Estimate
    {
        return new Estimate($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ExternalSalesInvoice
     */
    public function externalSalesInvoice(array $attributes = []): ExternalSalesInvoice
    {
        return new ExternalSalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ExternalSalesInvoiceDetail
     */
    public function externalSalesInvoiceDetail(array $attributes = []): ExternalSalesInvoiceDetail
    {
        return new ExternalSalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ExternalSalesInvoicePayment
     */
    public function externalSalesInvoicePayment(array $attributes = []): ExternalSalesInvoicePayment
    {
        return new ExternalSalesInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return FinancialAccount
     */
    public function financialAccount(array $attributes = []): FinancialAccount
    {
        return new FinancialAccount($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return FinancialMutation
     */
    public function financialMutation(array $attributes = []): FinancialMutation
    {
        return new FinancialMutation($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return FinancialStatement
     */
    public function financialStatement(array $attributes = []): FinancialStatement
    {
        return new FinancialStatement($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return GeneralDocument
     */
    public function generalDocument(array $attributes = []): GeneralDocument
    {
        return new GeneralDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return GeneralJournalDocument
     */
    public function generalJournalDocument(array $attributes = []): GeneralJournalDocument
    {
        return new GeneralJournalDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return GeneralJournalDocumentEntry
     */
    public function generalJournalDocumentEntry(array $attributes = []): GeneralJournalDocumentEntry
    {
        return new GeneralJournalDocumentEntry($this->connection, $attributes);
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param array $attributes
     *
     * @return Identity
     */
    public function identity(array $attributes = []): Identity
    {
        return new Identity($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ImportMapping
     */
    public function importMapping(array $attributes = []): ImportMapping
    {
        return new ImportMapping($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return LedgerAccount
     */
    public function ledgerAccount(array $attributes = []): LedgerAccount
    {
        return new LedgerAccount($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Product
     */
    public function product(array $attributes = []): Product
    {
        return new Product($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Project
     */
    public function project(array $attributes = []): Project
    {
        return new Project($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return PurchaseInvoice
     */
    public function purchaseInvoice(array $attributes = []): PurchaseInvoice
    {
        return new PurchaseInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return PurchaseInvoiceDetail
     */
    public function purchaseInvoiceDetail(array $attributes = []): PurchaseInvoiceDetail
    {
        return new PurchaseInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return PurchaseInvoicePayment
     */
    public function purchaseInvoicePayment(array $attributes = []): PurchaseInvoicePayment
    {
        return new PurchaseInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Receipt
     */
    public function receipt(array $attributes = []): Receipt
    {
        return new Receipt($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ReceiptDetail
     */
    public function receiptDetail(array $attributes = []): ReceiptDetail
    {
        return new ReceiptDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return ReceiptPayment
     */
    public function receiptPayment(array $attributes = []): ReceiptPayment
    {
        return new ReceiptPayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return RecurringSalesInvoice
     */
    public function recurringSalesInvoice(array $attributes = []): RecurringSalesInvoice
    {
        return new RecurringSalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return RecurringSalesInvoiceCustomField
     */
    public function recurringSalesInvoiceCustomField(array $attributes = []): RecurringSalesInvoiceCustomField
    {
        return new RecurringSalesInvoiceCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return RecurringSalesInvoiceDetail
     */
    public function recurringSalesInvoiceDetail(array $attributes = []): RecurringSalesInvoiceDetail
    {
        return new RecurringSalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return SalesInvoice
     */
    public function salesInvoice(array $attributes = []): SalesInvoice
    {
        return new SalesInvoice($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return SalesInvoiceCustomField
     */
    public function salesInvoiceCustomField(array $attributes = []): SalesInvoiceCustomField
    {
        return new SalesInvoiceCustomField($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return SalesInvoiceDetail
     */
    public function salesInvoiceDetail(array $attributes = []): SalesInvoiceDetail
    {
        return new SalesInvoiceDetail($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return SalesInvoicePayment
     */
    public function salesInvoicePayment(array $attributes = []): SalesInvoicePayment
    {
        return new SalesInvoicePayment($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return SalesInvoiceReminder
     */
    public function salesInvoiceReminder(array $attributes = []): SalesInvoiceReminder
    {
        return new SalesInvoiceReminder($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return TaxRate
     */
    public function taxRate(array $attributes = []): TaxRate
    {
        return new TaxRate($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return TimeEntry
     */
    public function timeEntry(array $attributes = []): TimeEntry
    {
        return new TimeEntry($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return TypelessDocument
     */
    public function typelessDocument(array $attributes = []): TypelessDocument
    {
        return new TypelessDocument($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return User
     */
    public function user(array $attributes = []): User
    {
        return new User($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Webhook
     */
    public function webhook(array $attributes = []): Webhook
    {
        return new Webhook($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Workflow
     */
    public function workflow(array $attributes = []): Workflow
    {
        return new Workflow($this->connection, $attributes);
    }

    /**
     * @param array $attributes
     *
     * @return Subscription
     */
    public function subscription(array $attributes = []): Subscription
    {
        return new Subscription($this->connection, $attributes);
    }
}
