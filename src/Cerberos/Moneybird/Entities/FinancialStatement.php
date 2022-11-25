<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class FinancialStatement extends Model
{
    use Storable, Removable;

    /**
     * @var array
     */
    protected array $fillable = [
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
    protected string $endpoint = 'financial_statements';

    /**
     * @var string
     */
    protected string $namespace = 'financial_statement';

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'financial_mutations' => [
            'entity' => FinancialMutation::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
