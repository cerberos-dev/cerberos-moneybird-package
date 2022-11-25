<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Model;

class GeneralJournalDocumentEntry extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'administration_id',
        'ledger_account_id',
        'contact_id',
        'description',
        'debit',
        'credit',
        'project_id',
        'row_order',
        'created_at',
        'updated_at',
    ];
}
