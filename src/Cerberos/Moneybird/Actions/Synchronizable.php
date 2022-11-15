<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Synchronizable
{
    use BaseTrait;

    /**
     * @param array $filters
     *
     * @return mixed
     *
     * @throws ApiException
     * @throws GuzzleException
     */
    public function listVersions(array $filters = [])
    {
        $filter = [];

        if (!empty($filters)) {
            $filterList = [];
            foreach ($filters as $key => $value) {
                $filterList[] = $key . ':' . $value;
            }

            $filter = ['filter' => implode(',', $filterList)];
        }

        $result = $this->connection()->get($this->getEndpoint() . '/synchronization', $filter);

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $ids
     *
     * @return mixed
     *
     * @throws ApiException
     * @throws GuzzleException
     */
    public function getVersions(array $ids)
    {
        $result = $this->connection()->post($this->getEndpoint() . '/synchronization', json_encode([
            'ids' => $ids,
        ]));

        return $this->collectionFromResult($result);
    }
}
