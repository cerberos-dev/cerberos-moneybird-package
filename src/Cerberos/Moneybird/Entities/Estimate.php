<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Downloadable;
use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Entities\SalesInvoice\SendInvoiceOptions;
use Cerberos\Moneybird\Model;
use InvalidArgumentException;

/**
 * Class Contact.
 *
 * @property int    $id
 * @property string $company_name
 * @property string $first_name
 * @property string $last_name
 */
class Estimate extends Model
{
    use FindAll, FindOne, Storable, Removable, Synchronizable, Filterable, Downloadable, Noteable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'administration_id',
        'contact_id',
        'contact_person_id',
        'contact',
        'estimate_id',
        'workflow_id',
        'document_style_id',
        'identity_id',
        'draft_id',
        'state',
        'estimate_date',
        'due_date',
        'reference',
        'language',
        'currency',
        'exchange_rate',
        'discount',
        'original_estimate_id',
        'show_tax',
        'sign_online',
        'sent_at',
        'accepted_at',
        'rejected_at',
        'archived_at',
        'created_at',
        'updated_at',
        'public_view_code',
        'version',
        'pre_text',
        'post_text',
        'details',
        'total_price_excl_tax',
        'total_price_excl_tax_base',
        'total_price_incl_tax',
        'total_price_incl_tax_base',
        'total_discount',
        'url',
        'custom_fields',
        'notes',
        'attachments',
        'events',
        'tax_totals',
        'prices_are_incl_tax',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'estimates';

    /**
     * @var string
     */
    protected $namespace = 'estimate';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'custom_fields' => [
            'entity' => SalesInvoiceCustomField::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'details'       => [
            'entity' => SalesInvoiceDetail::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'notes'         => [
            'entity' => Note::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'events'        => [
            'entity' => EstimateEvent::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
        'tax_totals'    => [
            'entity' => EstimateTaxTotal::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * Instruct Moneybird to send the estimate to the contact.
     *
     * @param string|SendInvoiceOptions $deliveryMethodOrOptions
     *
     * @return $this
     *
     * @throws ApiException
     */
    public function sendEstimate($deliveryMethodOrOptions = SendInvoiceOptions::METHOD_EMAIL)
    {
        if (is_string($deliveryMethodOrOptions)) {
            $options = new SendInvoiceOptions($deliveryMethodOrOptions);
        } else {
            $options = $deliveryMethodOrOptions;
        }

        unset($deliveryMethodOrOptions);

        if (!$options instanceof SendInvoiceOptions) {
            $options = is_object($options) ? get_class($options) : gettype($options);
            throw new InvalidArgumentException("Expected string or options instance. Received: '$options'");
        }

        $response = $this->connection->patch($this->endpoint . '/' . $this->id . '/send_estimate', json_encode([
            'estimate_sending' => $options->jsonSerialize(),
        ]));

        if (is_array($response)) {
            $this->selfFromResponse($response);
        }

        return $this;
    }
}
