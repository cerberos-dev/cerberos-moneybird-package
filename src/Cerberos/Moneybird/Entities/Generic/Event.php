<?php

namespace Cerberos\Moneybird\Entities\Generic;

use Cerberos\Moneybird\Model;

abstract class Event extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'administration_id',
        'user_id',
        'action',
        'link_entity_id',
        'link_entity_type',
        'data',
        'created_at',
        'updated_at',
    ];
}
