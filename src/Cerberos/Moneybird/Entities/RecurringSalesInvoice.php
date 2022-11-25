<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Model;

class RecurringSalesInvoice extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Noteable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'contact_id',
        'contact',
        'workflow_id',
        'state',
        'start_date',
        'invoice_date',
        'last_date',
        'payment_conditions',
        'reference',
        'language',
        'currency',
        'discount',
        'first_due_interval',
        'auto_send',
        'mergeable',
        'sending_scheduled_at',
        'sending_scheduled_user_id',
        'frequency_type',
        'frequency',
        'created_at',
        'updated_at',
        'details',
        'notes',
        'attachments',
        'has_desired_count',
        'desired_count',
        'version',
        'active',
        'custom_fields',
        'prices_are_incl_tax',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'recurring_sales_invoices';

    /**
     * @var string
     */
    protected string $namespace = 'recurring_sales_invoice';

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'details'       => [
            'entity' => RecurringSalesInvoiceDetail::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'custom_fields' => [
            'entity' => RecurringSalesInvoiceCustomField::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
