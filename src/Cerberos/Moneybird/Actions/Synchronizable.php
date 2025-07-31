<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Moneybird\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Synchronizable
{
    use BaseTrait;

    /**
     * @param array $filters
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return array
     */
    public function listVersions(array $filters = []): array
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
     * @throws ApiException
     * @throws GuzzleException
     * @return array
     */
    public function getVersions(array $ids): array
    {
        $result = $this->connection()->post($this->getEndpoint() . '/synchronization', json_encode([
            'ids' => $ids,
        ]));

        return $this->collectionFromResult($result);
    }
}
