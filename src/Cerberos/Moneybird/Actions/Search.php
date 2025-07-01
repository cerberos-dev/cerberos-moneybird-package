<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Search
{
    /**
     * @param $query
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return array
     */
    public function search($query, $perPage = null, $page = null): array
    {
        $result = $this->connection()->get($this->getEndpoint(), [
            'query'    => $query,
            'per_page' => $perPage,
            'page'     => $page,
        ], true);

        return $this->collectionFromResult($result);
    }
}
