<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Storable
{
    use BaseTrait;

    /**
     * @return bool|mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function save()
    {
        if ($this->exists()) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function insert()
    {
        $result = $this->connection()->post($this->getEndpoint(), $this->jsonWithNamespace());

        if (method_exists($this, 'clearDirty')) {
            $this->clearDirty();
        }

        return $this->selfFromResponse($result);
    }

    /**
     * @return mixed
     *
     * @throws ApiException
     * @throws GuzzleException
     */
    public function update()
    {
        $result = $this->connection()->patch($this->getEndpoint() . '/' . urlencode($this->id), $this->jsonWithNamespace());

        if ($result === 200) {
            if (method_exists($this, 'clearDirty')) {
                $this->clearDirty();
            }

            return true;
        }

        return $this->selfFromResponse($result);
    }
}
