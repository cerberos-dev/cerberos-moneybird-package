<?php

namespace Unit;

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
use Cerberos\Moneybird\Entities\GeneralDocument;
use Cerberos\Moneybird\Entities\GeneralJournalDocument;
use Cerberos\Moneybird\Entities\Identity;
use Cerberos\Moneybird\Entities\ImportMapping;
use Cerberos\Moneybird\Entities\LedgerAccount;
use Cerberos\Moneybird\Entities\Note;
use Cerberos\Moneybird\Entities\Product;
use Cerberos\Moneybird\Entities\Project;
use Cerberos\Moneybird\Entities\PurchaseInvoice;
use Cerberos\Moneybird\Entities\PurchaseInvoiceDetail;
use Cerberos\Moneybird\Entities\Receipt;
use Cerberos\Moneybird\Entities\ReceiptDetail;
use Cerberos\Moneybird\Entities\ReceiptPayment;
use Cerberos\Moneybird\Entities\RecurringSalesInvoice;
use Cerberos\Moneybird\Entities\RecurringSalesInvoiceCustomField;
use Cerberos\Moneybird\Entities\RecurringSalesInvoiceDetail;
use Cerberos\Moneybird\Entities\SalesInvoice;
use Cerberos\Moneybird\Entities\SalesInvoiceDetail;
use Cerberos\Moneybird\Entities\SalesInvoiceEvent;
use Cerberos\Moneybird\Entities\SalesInvoicePayment;
use Cerberos\Moneybird\Entities\SalesInvoiceReminder;
use Cerberos\Moneybird\Entities\SalesInvoiceTaxTotal;
use Cerberos\Moneybird\Entities\Subscription;
use Cerberos\Moneybird\Entities\TaxRate;
use Cerberos\Moneybird\Entities\TimeEntry;
use Cerberos\Moneybird\Entities\TypelessDocument;
use Cerberos\Moneybird\Entities\User;
use Cerberos\Moneybird\Entities\Webhook;
use Cerberos\Moneybird\Entities\Workflow;
use Cerberos\Moneybird\Moneybird;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class EntityTest.
 *
 * Tests all entities to ensure entities have no PHP parse errors and have
 * at least the properties we need to use the entity
 */
class EntityTest extends TestCase
{
    public function testAdministrationEntity(): void
    {
        $this->performEntityTest(Administration::class);
    }

    public function testContactEntity(): void
    {
        $this->performEntityTest(Contact::class);
    }

    public function testContactCustomFieldEntity(): void
    {
        $this->performEntityTest(ContactCustomField::class);
    }

    public function testCustomFieldEntity(): void
    {
        $this->performEntityTest(CustomField::class);
    }

    public function testDocumentStyleEntity(): void
    {
        $this->performEntityTest(DocumentStyle::class);
    }

    public function testEstimateEntity(): void
    {
        $this->performEntityTest(Estimate::class);
    }

    public function testExternalSalesInvoice(): void
    {
        $this->performEntityTest(ExternalSalesInvoice::class);
    }

    public function testExternalSalesInvoiceDetail(): void
    {
        $this->performEntityTest(ExternalSalesInvoiceDetail::class);
    }

    public function testExternalSalesInvoicePayment(): void
    {
        $this->performEntityTest(ExternalSalesInvoicePayment::class);
    }

    public function testFinancialAccountEntity(): void
    {
        $this->performEntityTest(FinancialAccount::class);
    }

    public function testFinancialMutationEntity(): void
    {
        $this->performEntityTest(FinancialMutation::class);
    }

    public function testGeneralDocumentEntity(): void
    {
        $this->performEntityTest(GeneralDocument::class);
    }

    public function testGeneralJournalDocumentEntity(): void
    {
        $this->performEntityTest(GeneralJournalDocument::class);
    }

    public function testIdentityEntity(): void
    {
        $this->performEntityTest(Identity::class);
    }

    public function testImportMappingEntity(): void
    {
        $this->performEntityTest(ImportMapping::class);
    }

    public function testLedgerAccountEntity(): void
    {
        $this->performEntityTest(LedgerAccount::class);
    }

    public function testProductEntity(): void
    {
        $this->performEntityTest(Product::class);
    }

    public function testProjectEntity(): void
    {
        $this->performEntityTest(Project::class);
    }

    public function testPurchaseInvoiceEntity(): void
    {
        $this->performEntityTest(PurchaseInvoice::class);
    }

    public function testPurchaseDetailInvoiceEntity(): void
    {
        $this->performEntityTest(PurchaseInvoiceDetail::class);
    }

    public function testReceiptEntity(): void
    {
        $this->performEntityTest(Receipt::class);
    }

    public function testReceiptDetailEntity(): void
    {
        $this->performEntityTest(ReceiptDetail::class);
    }

    public function testReceiptPaymentEntity(): void
    {
        $this->performEntityTest(ReceiptPayment::class);
    }

    public function testRecurringSalesInvoiceEntity(): void
    {
        $this->performEntityTest(RecurringSalesInvoice::class);
    }

    public function testRecurringSalesInvoiceDetailEntity(): void
    {
        $this->performEntityTest(RecurringSalesInvoiceDetail::class);
    }

    public function testRecurringSalesInvoiceCustomFieldEntity(): void
    {
        $this->performEntityTest(RecurringSalesInvoiceCustomField::class);
    }

    public function testSalesInvoiceEntity(): void
    {
        $this->performEntityTest(SalesInvoice::class);
    }

    public function testSalesInvoiceDetailEntity(): void
    {
        $this->performEntityTest(SalesInvoiceDetail::class);
    }

    public function testSalesInvoiceEventEntity(): void
    {
        $this->performEntityTest(SalesInvoiceEvent::class);
    }

    public function testSalesInvoicePaymentEntity(): void
    {
        $this->performEntityTest(SalesInvoicePayment::class);
    }

    public function testSalesInvoiceReminderEntity(): void
    {
        $this->performEntityTest(SalesInvoiceReminder::class);
    }

    public function testSalesInvoiceTaxTotalEntity(): void
    {
        $this->performEntityTest(SalesInvoiceTaxTotal::class);
    }

    public function testSubscriptionEntity(): void
    {
        $this->performEntityTest(Subscription::class);
    }

    public function testNoteEntity(): void
    {
        $this->performEntityTest(Note::class);
    }

    public function testTaxRateEntity(): void
    {
        $this->performEntityTest(TaxRate::class);
    }

    public function testTimeEntryEntity(): void
    {
        $this->performEntityTest(TimeEntry::class);
    }

    public function testTypelessDocumentEntity(): void
    {
        $this->performEntityTest(TypelessDocument::class);
    }

    public function testUserEntity(): void
    {
        $this->performEntityTest(User::class);
    }

    public function testWebhookEntity(): void
    {
        $this->performEntityTest(Webhook::class);
    }

    public function testWorkflowEntity(): void
    {
        $this->performEntityTest(Workflow::class);
    }

    public function testMoneybirdClass(): void
    {
        $reflectionClass = new ReflectionClass(Moneybird::class);

        $this->assertTrue($reflectionClass->isInstantiable());
        $this->assertTrue($reflectionClass->hasProperty('connection'));
        $this->assertEquals('Cerberos\Moneybird', $reflectionClass->getNamespaceName());
    }

    /**
     * @param $entityName
     */
    private function performEntityTest(string $entityName): void
    {
        $reflectionClass = new ReflectionClass($entityName);

        $this->assertTrue($reflectionClass->isInstantiable());
        $this->assertTrue($reflectionClass->hasProperty('fillable'));
        $this->assertTrue($reflectionClass->hasProperty('endpoint'));
        $this->assertEquals('Cerberos\Moneybird\Entities', $reflectionClass->getNamespaceName());
    }
}
