<?php

namespace Cerberos\Moneybird\Entities\Generic;

use Cerberos\Moneybird\Model;

abstract class CustomField extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'value',
    ];
}
