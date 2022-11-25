<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class EstimateTaxTotal extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'tax_rate_id',
        'taxable_amount',
        'taxable_amount_base',
        'tax_amount',
        'tax_amount_base',
    ];
}
