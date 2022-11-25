<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class GeneralJournalDocument extends Model
{
    use FindAll, FindOne, Storable, Removable, Noteable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'reference',
        'date',
        'created_at',
        'updated_at',
        'general_journal_document_entries',
        'notes',
        'attachments',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'documents/general_journal_documents';

    /**
     * @var string
     */
    protected string $namespace = 'general_journal_document';

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'general_journal_document_entries' => [
            'entity' => GeneralJournalDocumentEntry::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
