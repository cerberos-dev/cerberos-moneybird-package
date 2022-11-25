<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class ReceiptPayment extends Model
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
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected string $namespace = 'payment';
}
