<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Noteable;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Model;

/**
 * Class GeneralDocument.
 */
class GeneralDocument extends Model
{
    use FindAll, FindOne, Storable, Removable, Synchronizable, Noteable;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'due_date',
        'entry_number',
        'state',
        'exchange_rate',
        'created_at',
        'updated_at',
        'notes',
        'attachments',
    ];

    /**
     * @var string
     */
    protected $endpoint = 'documents/general_documents';

    /**
     * @var string
     */
    protected $namespace = 'general_document';
}
