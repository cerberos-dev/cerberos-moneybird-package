<?php

namespace Cerberos\Moneybird\Entities\Generic;

use Cerberos\Moneybird\Model;

abstract class InvoicePayment extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'invoice_type',
        'invoice_id',
        'financial_account_id',
        'user_id',
        'payment_transaction_id',
        'price',
        'price_base',
        'payment_date',
        'credit_invoice_id',
        'financial_mutation_id',
        'transaction_identifier',
        'manual_payment_action',
        'ledger_account_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected string $namespace = 'payment';
}
