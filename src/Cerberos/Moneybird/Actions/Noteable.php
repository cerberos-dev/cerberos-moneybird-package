<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Moneybird\Entities\Note;
use Cerberos\Moneybird\Exceptions\ApiException;
use GuzzleHttp\Exception\GuzzleException;

trait Noteable
{
    use BaseTrait;

    /**
     * Add a note to the current object.
     *
     * @param Note $note
     *
     * @throws ApiException
     * @throws GuzzleException
     * @return $this
     */
    public function addNote(Note $note): static
    {
        $this->connection()->post(
            $this->getEndpoint() . '/' . urlencode($this->id) . '/notes',
            $note->jsonWithNamespace()
        );

        return $this;
    }
}
