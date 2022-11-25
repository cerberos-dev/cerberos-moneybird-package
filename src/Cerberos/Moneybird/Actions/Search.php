<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Search
{
    /**
     * @param      $query
     * @param null $perPage
     * @param null $page
     *
     * @return array
     * @throws ApiException
     * @throws GuzzleException
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
