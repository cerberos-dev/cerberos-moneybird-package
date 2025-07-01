<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Filterable
{
    use BaseTrait;

    /**
     * @param array $filters
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return array
     */
    public function filter(array $filters): array
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key . ':' . $value;
        }

        $result = $this->connection()->get($this->getFilterEndpoint(), ['filter' => implode(',', $filterList)]);

        return $this->collectionFromResult($result);
    }

    /**
     * @param array $filters
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return array
     */
    public function filterAll(array $filters): array
    {
        $filterList = [];
        foreach ($filters as $key => $value) {
            $filterList[] = $key . ':' . $value;
        }

        $result = $this->connection()->get($this->getFilterEndpoint(), ['filter' => implode(',', $filterList)], true);

        return $this->collectionFromResult($result);
    }
}
