<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Search;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Exceptions\ApiException;
use Cerberos\Moneybird\Model;

/**
 * Class Product.
 */
class Product extends Model
{
    use Search, FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'title',
        'identifier',
        'price',
        'currency',
        'frequency',
        'frequency_type',
        'tax_rate_id',
        'ledger_account_id',
        'identifier',
        'product_type',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'products';

    /**
     * @var string
     */
    protected $namespace = 'product';

    /**
     * @param string|int $identifier
     *
     * @return static
     *
     * @throws ApiException
     */
    public function findByIdentifier($identifier)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/identifier/' . urlencode($identifier));

        return $this->makeFromResponse($result);
    }
}
