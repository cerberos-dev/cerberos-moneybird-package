<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

/**
 * Class GeneralJournalDocument.
 */
class GeneralJournalDocument extends Model
{
    use FindAll, FindOne, Storable, Removable, Noteable;

    /**
     * @var array
     */
    protected $fillable = [
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
    protected $endpoint = 'documents/general_journal_documents';

    /**
     * @var string
     */
    protected $namespace = 'general_journal_document';

    /**
     * @var array
     */
    protected $multipleNestedEntities = [
        'general_journal_document_entries' => [
            'entity' => GeneralJournalDocumentEntry::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];
}
