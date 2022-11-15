<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait FindOne
{
    use BaseTrait;

    /**
     * @param string|int $id
     *
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function find($id)
    {
        $result = $this->connection()->get($this->getEndpoint() . '/' . urlencode($id));

        return $this->makeFromResponse($result);
    }
}
