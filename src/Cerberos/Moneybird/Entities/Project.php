<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

/**
 * Class Project.
 */
class Project extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'state',
        'budget',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'projects';

    /**
     * @var string
     */
    protected $namespace = 'project';
}
