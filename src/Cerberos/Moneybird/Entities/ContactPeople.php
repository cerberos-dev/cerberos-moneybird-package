<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class ContactPeople extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'administration_id',
        'firstname',
        'lastname',
        'phone',
        'email',
        'department',
        'created_at',
        'updated_at',
        'version',
    ];
}
