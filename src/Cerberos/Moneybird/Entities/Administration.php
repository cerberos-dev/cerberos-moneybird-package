<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Model;

class Administration extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'name',
        'language',
        'currency',
        'country',
        'time_zone',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'administrations';
}
