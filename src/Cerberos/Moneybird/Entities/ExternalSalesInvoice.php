<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Attachment;
use Cerberos\Moneybird\Actions\Downloadable;
use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Connection;
use Cerberos\Moneybird\Model;

/**
 * Class ExternalSalesInvoice.
 *
 * @property string  $id
 * @property Contact $contact
 */
class ExternalSalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Downloadable, Synchronizable, Attachment;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'due_date',
        'entry_number',
        'state',
        'currency',
        'prices_are_incl_tax',
        'source',
        'source_url',
        'origin',
        'paid_at',
        'total_paid',
        'total_unpaid',
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
    protected $endpoint = 'external_sales_invoices';

    /**
     * @var string
     */
    protected $namespace = 'external_sales_invoice';

    /**
     * @var array
     */
    protected $singleNestedEntities = [
        'contact' => Contact::class,
    ];

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'details'  => [
            'entity' => ExternalSalesInvoiceDetail::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'payments' => [
            'entity' => ExternalSalesInvoicePayment::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection, $attributes);

        $this->attachmentPath = 'attachment';
    }
}
