<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Model;

class ImportMapping extends Model
{
    use FindAll, FindOne;

    /**
     * @var string|null
     */
    protected ?string $type;

    /**
     * @var array
     */
    protected array $fillable = [
        'administration_id',
        'entity_type',
        'old_id',
        'new_id',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'import_mappings';

    /**
     * @param string $type The type of import mapping to request
     *
     * Type should be any of: financial_account bank_mutation contact document_attachment general_journal identity
     * incoming_invoice attachment payment history invoice_attachment transaction ledger_account tax_rate product
     * print_invoice recurring_template invoice workflow document_style
     *
     * @return $this
     */
    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        if (null === $this->type) {
            return $this->endpoint;
        }

        return $this->endpoint . '/' . $this->type;
    }
}
