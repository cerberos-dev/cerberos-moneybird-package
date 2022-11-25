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
     * @return array
     * @throws ApiException
     * @throws GuzzleException
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
     * @return array
     * @throws ApiException
     * @throws GuzzleException
     */
    public function getVersions(array $ids): array
    {
        $result = $this->connection()->post($this->getEndpoint() . '/synchronization', json_encode([
            'ids' => $ids,
        ]));

        return $this->collectionFromResult($result);
    }
}
