<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class ContactCustomField extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'name',
        'value',
    ];
}
