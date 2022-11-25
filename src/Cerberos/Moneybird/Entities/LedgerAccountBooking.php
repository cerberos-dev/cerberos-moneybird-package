<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class LedgerAccountBooking extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'administration_id',
        'ledger_account_id',
        'description',
        'price',
        'created_at',
        'updated_at',
    ];
}
