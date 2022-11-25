<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class Webhook extends Model
{
    use FindAll, Storable, Removable;

    const JSON_OPTIONS = 0;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'url',
        'events',
        'last_http_status',
        'last_http_body',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'webhooks';
}
