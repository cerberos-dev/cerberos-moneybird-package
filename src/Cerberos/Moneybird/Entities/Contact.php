<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Search;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Model;
use GuzzleHttp\Exception\GuzzleException;

class Contact extends Model
{
    use Search, FindAll, FindOne, Storable, Removable, Filterable, Synchronizable, Noteable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'company_name',
        'firstname',
        'lastname',
        'attention',
        'address1',
        'address2',
        'zipcode',
        'city',
        'country',
        'email',
        'phone',
        'delivery_method',
        'customer_id',
        'tax_number',
        'chamber_of_commerce',
        'bank_account',
        'send_invoices_to_attention',
        'send_invoices_to_email',
        'send_estimates_to_attention',
        'send_estimates_to_email',
        'sepa_active',
        'sepa_iban',
        'sepa_iban_account_name',
        'sepa_bic',
        'sepa_mandate_id',
        'sepa_mandate_date',
        'sepa_sequence_type',
        'credit_card_number',
        'credit_card_reference',
        'credit_card_type',
        'invoice_workflow_id',
        'estimate_workflow_id',
        'email_ubl',
        'tax_number_validated_at',
        'created_at',
        'updated_at',
        'notes',
        'custom_fields',
        'contact_people',
        'version',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'contacts';

    /**
     * @var string
     */
    protected string $namespace = 'contact';

    /**
     * @var string
     */
    protected string $filterEndpoint = 'contacts/filter';

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'custom_fields'  => [
            'entity' => ContactCustomField::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'contact_people' => [
            'entity' => ContactPeople::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];

    /**
     * @param int|string $customerId
     *
     * @return Contact
     * @throws ApiException
     * @throws GuzzleException
     */
    public function findByCustomerId(int|string $customerId): Contact
    {
        $result = $this->connection()->get($this->getEndpoint() . '/customer_id/' . urlencode($customerId));

        return $this->makeFromResponse($result);
    }
}
