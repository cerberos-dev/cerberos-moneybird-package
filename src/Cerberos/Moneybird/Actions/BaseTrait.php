<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Moneybird\Connection;

trait BaseTrait
{
    /**
     * @return Connection
     *
     * @see \Cerberos\Moneybird\Model::connection()
     */
    abstract protected function connection();

    /**
     * @return string
     *
     * @see \Cerberos\Moneybird\Model::getEndpoint()
     */
    abstract protected function getEndpoint();

    /**
     * @param array $result
     *
     * @return array
     *
     * @see \Cerberos\Moneybird\Model::collectionFromResult()
     */
    abstract protected function collectionFromResult(array $result);

    /**
     * Create a new object with the response from the API.
     *
     * @param array $response
     *
     * @return static
     *
     * @see \Cerberos\Moneybird\Model::makeFromResponse()
     */
    abstract protected function makeFromResponse(array $response);
}
