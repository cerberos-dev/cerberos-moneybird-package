<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class Identity extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'company_name',
        'city',
        'country',
        'zipcode',
        'address1',
        'address2',
        'email',
        'phone',
        'bank_account_name',
        'bank_account_number',
        'bank_account_bic',
        'custom_fields',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'identities';

    /**
     * @var string
     */
    protected string $namespace = 'identity';
}
