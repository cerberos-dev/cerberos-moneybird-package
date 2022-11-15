<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

/**
 * Class FinancialStatement.
 */
class FinancialStatement extends Model
{
    use Storable, Removable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'financial_account_id',
        'reference',
        'official_date',
        'official_balance',
        'importer_service',
        'financial_mutations',
        'update_journal_entries',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'financial_statements';

    /**
     * @var string
     */
    protected $namespace = 'financial_statement';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'financial_mutations' => [
            'entity' => FinancialMutation::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
