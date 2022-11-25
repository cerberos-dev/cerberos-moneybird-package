<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class TimeEntry extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'user_id',
        'user',
        'started_at',
        'ended_at',
        'paused_duration',
        'contact_id',
        'project_id',
        'project',
        'detail_id',
        'detail',
        'description',
        'billable',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'time_entries';

    /**
     * @var string
     */
    protected string $namespace = 'time_entry';

    /**
     * @var array
     */
    protected array $singleNestedEntities = [
        'user'    => User::class,
        'project' => Project::class,
        'detail'  => SalesInvoiceDetail::class,
    ];
}
