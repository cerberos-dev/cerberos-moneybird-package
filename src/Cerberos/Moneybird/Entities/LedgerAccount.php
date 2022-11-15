<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

/**
 * Class LedgerAccount.
 */
class LedgerAccount extends Model
{
    use FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'account_type',
        'account_id',
        'parent_id',
        'allowed_document_types',
        'created_at',
        'updated_at',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'ledger_accounts';

    /**
     * @var string
     */
    protected $namespace = 'ledger_account';
}
