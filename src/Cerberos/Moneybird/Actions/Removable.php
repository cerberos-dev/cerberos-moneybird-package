<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Removable
{
    use BaseTrait;

    /**
     * @return mixed
     *
     * @throws ApiException
     * @throws GuzzleException
     */
    public function delete(): mixed
    {
        return $this->connection()->delete($this->getEndpoint() . '/' . urlencode($this->id));
    }
}
