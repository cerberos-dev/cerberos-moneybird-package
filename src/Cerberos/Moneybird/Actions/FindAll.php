<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Moneybird\Exceptions\ApiException;
use Cerberos\Moneybird\Exceptions\TooManyRequestsException;
use GuzzleHttp\Exception\GuzzleException;

trait FindAll
{
    use BaseTrait;

    /**
     * @param array $params
     *
     * @throws ApiException
     * @throws GuzzleException
     * @throws TooManyRequestsException
     * @return array
     *
     */
    public function get(array $params = []): array
    {
        $result = $this->connection()->get($this->getEndpoint(), $params);

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $params
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return array
     *
     */
    public function getAll(array $params = []): array
    {
        $result = $this->connection()->get($this->getEndpoint(), $params, true);

        return $this->collectionFromResult($result);
    }
}
