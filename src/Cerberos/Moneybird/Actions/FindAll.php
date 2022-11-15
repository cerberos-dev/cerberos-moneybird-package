<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use Cerberos\Exceptions\TooManyRequestsException;
use GuzzleHttp\Exception\GuzzleException;

trait FindAll
{
    use BaseTrait;

    /**
     * @param array $params
     *
     * @return array
     *
     * @throws ApiException
     * @throws GuzzleException
     * @throws TooManyRequestsException
     */
    public function get($params = [])
    {
        $result = $this->connection()->get($this->getEndpoint(), $params);

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @throws ApiException
     * @throws GuzzleException
     */
    public function getAll($params = [])
    {
        $result = $this->connection()->get($this->getEndpoint(), $params, true);

        return $this->collectionFromResult($result);
    }
}
