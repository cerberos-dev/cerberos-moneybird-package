<?php

namespace Cerberos\Moneybird\Entities\Generic;

use Cerberos\Moneybird\Model;

abstract class InvoiceDetail extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'tax_rate_id',
        'ledger_account_id',
        'amount',
        'amount_decimal',
        'description',
        'period',
        'price',
        'row_order',
        'total_price_excl_tax_with_discount',
        'total_price_excl_tax_with_discount_base',
        'tax_report_reference',
        'created_at',
        'updated_at',
        'product_id',
        'project_id',
        '_destroy',
        'project_id',
    ];
}
