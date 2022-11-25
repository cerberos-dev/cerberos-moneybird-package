<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class Note extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'note',
        'todo',
        'assignee_id',
    ];

    /**
     * @var string
     */
    protected string $namespace = 'note';
}
