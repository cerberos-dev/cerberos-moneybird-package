<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class Subscription extends Model
{
    use FindAll, FindOne, Storable, Removable, Filterable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'start_date',
        'product_id',
        'contact_id',
        'end_date',
        'reference',
        'document_style_id',
        'frequency',
        'frequency_type',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'subscriptions';

    /**
     * @var string
     */
    protected $namespace = 'subscription';
}
