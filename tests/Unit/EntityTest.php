<?php

namespace Cerberos\Tests;

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
    public function testAdministrationEntity()
    {
        $this->performEntityTest(Administration::class);
    }

    public function testContactEntity()
    {
        $this->performEntityTest(Contact::class);
    }

    public function testContactCustomFieldEntity()
    {
        $this->performEntityTest(ContactCustomField::class);
    }

    public function testCustomFieldEntity()
    {
        $this->performEntityTest(CustomField::class);
    }

    public function testDocumentStyleEntity()
    {
        $this->performEntityTest(DocumentStyle::class);
    }

    public function testEstimateEntity()
    {
        $this->performEntityTest(Estimate::class);
    }

    public function testExternalSalesInvoice()
    {
        $this->performEntityTest(ExternalSalesInvoice::class);
    }

    public function testExternalSalesInvoiceDetail()
    {
        $this->performEntityTest(ExternalSalesInvoiceDetail::class);
    }

    public function testExternalSalesInvoicePayment()
    {
        $this->performEntityTest(ExternalSalesInvoicePayment::class);
    }

    public function testFinancialAccountEntity()
    {
        $this->performEntityTest(FinancialAccount::class);
    }

    public function testFinancialMutationEntity()
    {
        $this->performEntityTest(FinancialMutation::class);
    }

    public function testGeneralDocumentEntity()
    {
        $this->performEntityTest(GeneralDocument::class);
    }

    public function testGeneralJournalDocumentEntity()
    {
        $this->performEntityTest(GeneralJournalDocument::class);
    }

    public function testIdentityEntity()
    {
        $this->performEntityTest(Identity::class);
    }

    public function testImportMappingEntity()
    {
        $this->performEntityTest(ImportMapping::class);
    }

    public function testLedgerAccountEntity()
    {
        $this->performEntityTest(LedgerAccount::class);
    }

    public function testProductEntity()
    {
        $this->performEntityTest(Product::class);
    }

    public function testProjectEntity()
    {
        $this->performEntityTest(Project::class);
    }

    public function testPurchaseInvoiceEntity()
    {
        $this->performEntityTest(PurchaseInvoice::class);
    }

    public function testPurchaseDetailInvoiceEntity()
    {
        $this->performEntityTest(PurchaseInvoiceDetail::class);
    }

    public function testReceiptEntity()
    {
        $this->performEntityTest(Receipt::class);
    }

    public function testReceiptDetailEntity()
    {
        $this->performEntityTest(ReceiptDetail::class);
    }

    public function testReceiptPaymentEntity()
    {
        $this->performEntityTest(ReceiptPayment::class);
    }

    public function testRecurringSalesInvoiceEntity()
    {
        $this->performEntityTest(RecurringSalesInvoice::class);
    }

    public function testRecurringSalesInvoiceDetailEntity()
    {
        $this->performEntityTest(RecurringSalesInvoiceDetail::class);
    }

    public function testRecurringSalesInvoiceCustomFieldEntity()
    {
        $this->performEntityTest(RecurringSalesInvoiceCustomField::class);
    }

    public function testSalesInvoiceEntity()
    {
        $this->performEntityTest(SalesInvoice::class);
    }

    public function testSalesInvoiceDetailEntity()
    {
        $this->performEntityTest(SalesInvoiceDetail::class);
    }

    public function testSalesInvoiceEventEntity()
    {
        $this->performEntityTest(SalesInvoiceEvent::class);
    }

    public function testSalesInvoicePaymentEntity()
    {
        $this->performEntityTest(SalesInvoicePayment::class);
    }

    public function testSalesInvoiceReminderEntity()
    {
        $this->performEntityTest(SalesInvoiceReminder::class);
    }

    public function testSalesInvoiceTaxTotalEntity()
    {
        $this->performEntityTest(SalesInvoiceTaxTotal::class);
    }

    public function testSubscriptionEntity()
    {
        $this->performEntityTest(Subscription::class);
    }

    public function testNoteEntity()
    {
        $this->performEntityTest(Note::class);
    }

    public function testTaxRateEntity()
    {
        $this->performEntityTest(TaxRate::class);
    }

    public function testTimeEntryEntity()
    {
        $this->performEntityTest(TimeEntry::class);
    }

    public function testTypelessDocumentEntity()
    {
        $this->performEntityTest(TypelessDocument::class);
    }

    public function testUserEntity()
    {
        $this->performEntityTest(User::class);
    }

    public function testWebhookEntity()
    {
        $this->performEntityTest(Webhook::class);
    }

    public function testWorkflowEntity()
    {
        $this->performEntityTest(Workflow::class);
    }

    public function testMoneybirdClass()
    {
        $reflectionClass = new ReflectionClass(Moneybird::class);

        $this->assertTrue($reflectionClass->isInstantiable());
        $this->assertTrue($reflectionClass->hasProperty('connection'));
        $this->assertEquals('Cerberos\Moneybird', $reflectionClass->getNamespaceName());
    }

    /**
     * @param $entityName
     */
    private function performEntityTest($entityName)
    {
        $reflectionClass = new ReflectionClass($entityName);

        $this->assertTrue($reflectionClass->isInstantiable());
        $this->assertTrue($reflectionClass->hasProperty('fillable'));
        $this->assertTrue($reflectionClass->hasProperty('endpoint'));
        $this->assertEquals('Cerberos\Moneybird\Entities', $reflectionClass->getNamespaceName());
    }
}
