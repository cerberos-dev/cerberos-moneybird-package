<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Model;

/**
 * Class CustomField.
 */
class CustomField extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'source',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'custom_fields';
}
