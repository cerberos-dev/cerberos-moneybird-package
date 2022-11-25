<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Actions\Attachment;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;
use GuzzleHttp\Exception\GuzzleException;

class Receipt extends Model
{
    use FindAll, FindOne, Storable, Removable, Attachment, Noteable;

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
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'documents/receipts';

    /**
     * @var string
     */
    protected string $namespace = 'receipt';

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'details' => [
            'entity' => ReceiptDetail::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Register a payment for the current purchase invoice.
     *
     * @param ReceiptPayment $receiptPayment (payment_date and price are required)
     *
     * @return $this
     *
     * @throws ApiException
     * @throws GuzzleException
     */
    public function registerPayment(ReceiptPayment $receiptPayment): static
    {
        if (!isset($receiptPayment->payment_date)) {
            throw new ApiException('Required [payment_date] is missing');
        }

        if (!isset($receiptPayment->price)) {
            throw new ApiException('Required [price] is missing');
        }

        $this->connection()->post(
            $this->endpoint . '/' . $this->id . '/payments',
            $receiptPayment->jsonWithNamespace()
        );

        return $this;
    }
}
