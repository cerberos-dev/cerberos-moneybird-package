<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class ReceiptDetail extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'description',
        'period',
        'price',
        'amount',
        'tax_rate_id',
        'ledger_account_id',
        'row_order',
        '_destroy',
    ];
}
