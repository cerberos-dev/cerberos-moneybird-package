<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Model;

class CustomField extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'name',
        'source',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'custom_fields';
}
