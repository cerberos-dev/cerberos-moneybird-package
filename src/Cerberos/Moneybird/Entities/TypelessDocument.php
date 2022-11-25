<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Moneybird\Actions\Attachment;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\FindOne;
use Cerberos\Moneybird\Actions\Removable;
use Cerberos\Moneybird\Actions\Storable;
use Cerberos\Moneybird\Model;

class TypelessDocument extends Model
{
    use Attachment, FindAll, FindOne, Storable, Removable;

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'contact_id',
        'reference',
        'date',
        'state',
        'origin',
        'created_at',
        'updated_at',
        'attachments',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'documents/typeless_documents';

    /**
     * @var string
     */
    protected string $namespace = 'typeless_document';
}
