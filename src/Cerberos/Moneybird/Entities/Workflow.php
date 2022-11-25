<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Model;

class Workflow extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'type',
        'name',
        'default',
        'currency',
        'language',
        'active',
        'prices_are_incl_tax',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'workflows';
}
