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
    abstract protected function connection(): Connection;

    /**
     * @return string
     *
     * @see \Cerberos\Moneybird\Model::getEndpoint()
     */
    abstract protected function getEndpoint(): string;

    /**
     * @param array $result
     *
     * @return array
     *
     * @see \Cerberos\Moneybird\Model::collectionFromResult()
     */
    abstract protected function collectionFromResult(array $result): array;

    /**
     * Create a new object with the response from the API.
     *
     * @param array $response
     *
     * @return static
     *
     * @see \Cerberos\Moneybird\Model::makeFromResponse()
     */
    abstract protected function makeFromResponse(array $response): static;
}
