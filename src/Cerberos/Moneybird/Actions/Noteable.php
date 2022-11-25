<?php

namespace Cerberos\Moneybird\Actions;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Entities\Note;
use GuzzleHttp\Exception\GuzzleException;

trait Noteable
{
    use BaseTrait;

    /**
     * Add a note to the current object.
     *
     * @param Note $note
     *
     * @return $this
     * @throws ApiException
     * @throws GuzzleException
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
