<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Search;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;
use GuzzleHttp\Exception\GuzzleException;

class Product extends Model
{
    use Search;
    use FindAll;
    use FindOne;
    use Storable;
    use Removable;

    /**
     * @var array
     */
    protected array $fillable = [
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
    protected string $endpoint = 'products';

    /**
     * @var string
     */
    protected string $namespace = 'product';

    /**
     * @param int|string $identifier
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return Product
     */
    public function findByIdentifier(int | string $identifier): Product
    {
        $result = $this->connection()->get($this->getEndpoint() . '/identifier/' . urlencode($identifier));

        return $this->makeFromResponse($result);
    }
}
