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
     * @return array
     * @throws ApiException
     * @throws GuzzleException
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
     * @return array
     * @throws ApiException
     * @throws GuzzleException
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
