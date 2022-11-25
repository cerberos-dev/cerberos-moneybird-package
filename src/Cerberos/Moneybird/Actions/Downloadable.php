<?php

namespace Cerberos\Moneybird\Actions;

use GuzzleHttp\Exception\GuzzleException;

trait Downloadable
{
    use BaseTrait;

    /**
     * Download as PDF.
     *
     * @return string PDF file data
     * @throws GuzzleException
     */
    public function download(): string
    {
        $response = $this->connection()->download($this->getEndpoint() . '/' . urlencode($this->id) . '/download_pdf');

        return $response->getBody()->getContents();
    }
}
