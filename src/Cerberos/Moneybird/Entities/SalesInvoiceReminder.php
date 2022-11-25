<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Model;
use GuzzleHttp\Exception\GuzzleException;

class SalesInvoiceReminder extends Model
{
    /**
     * @var array
     */
    protected array $fillable = [
        'contact_id',
        'workflow_id',
        'identity_id',
        'document_style_id',
        'sales_invoices',
        'reminder_text',
        'delivery_method',
        'email_address',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'sales_invoices';

    /**
     * @var string
     */
    protected string $namespace = 'sales_invoice_reminders';

    /**
     * Pushes the reminder.
     *
     * @return void
     * @throws ApiException
     * @throws GuzzleException
     */
    public function send(): void
    {
        $aReminder = $this->json();
        $aReminder = json_decode($aReminder, true);

        $aReminder['sales_invoice_ids'] = array_map(function ($salesInvoice) {
            if (is_object($salesInvoice)) {
                return $salesInvoice->id;
            } else {
                return $salesInvoice;
            }
        }, $this->sales_invoices);
        unset($aReminder['sales_invoices']);

        $this->connection->post($this->endpoint . '/send_reminders', json_encode([
            'sales_invoice_reminders' => [$aReminder],
        ]));
    }
}
