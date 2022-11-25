<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Model;

class TaxRate extends Model
{
    use FindAll;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'name',
        'percentage',
        'tax_rate_type',
        'show_tax',
        'active',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'tax_rates';
}
