<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Actions\Attachment;
use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Model;
use GuzzleHttp\Exception\GuzzleException;

class PurchaseInvoice extends Model
{
    use FindAll;
    use FindOne;
    use Storable;
    use Removable;
    use Filterable;
    use Synchronizable;
    use Attachment;
    use Noteable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'due_date',
        'entry_number',
        'state',
        'currency',
        'exchange_rate',
        'revenue_invoice',
        'prices_are_incl_tax',
        'origin',
        'paid_at',
        'tax_number',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'created_at',
        'updated_at',
        'details',
        'payments',
        'notes',
        'attachments',
        'version',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'documents/purchase_invoices';

    /**
     * @var string
     */
    protected string $namespace = 'purchase_invoice';

    /**
     * @var array
     */
    protected array $singleNestedEntities = [
        'contact' => Contact::class,
    ];

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'details' => [
            'entity' => PurchaseInvoiceDetail::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => PurchaseInvoicePayment::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Register a payment for the current purchase invoice.
     *
     * @param PurchaseInvoicePayment $purchaseInvoicePayment (payment_date and price are required)
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return $this
     *
     */
    public function registerPayment(PurchaseInvoicePayment $purchaseInvoicePayment): static
    {
        if (!property_exists($purchaseInvoicePayment, 'payment_date') || $purchaseInvoicePayment->payment_date === null) {
            throw new ApiException('Required [payment_date] is missing');
        }

        if (!property_exists($purchaseInvoicePayment, 'price') || $purchaseInvoicePayment->price === null) {
            throw new ApiException('Required [price] is missing');
        }

        $this->connection()->patch(
            $this->endpoint . '/' . $this->id . '/register_payment',
            $purchaseInvoicePayment->jsonWithNamespace()
        );

        return $this;
    }
}
