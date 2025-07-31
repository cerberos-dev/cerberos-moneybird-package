<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Moneybird\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Removable
{
    use BaseTrait;

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @return mixed
     *
     */
    public function delete(): mixed
    {
        return $this->connection()->delete($this->getEndpoint() . '/' . urlencode($this->id));
    }
}
