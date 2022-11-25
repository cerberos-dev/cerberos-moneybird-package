<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Model;

class User extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
        'email',
        'email_validated',
        'language',
        'time_zone',
        'permissions',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'users';
}
