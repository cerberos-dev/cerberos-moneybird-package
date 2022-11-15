<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

/**
 * Class ContactCustomField.
 *
 * @property string $id
 * @property string $name
 * @property string $value
 */
class ContactCustomField extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'value',
    ];
}
