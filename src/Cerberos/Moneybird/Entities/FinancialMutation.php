<?php

namespace Cerberos\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Exceptions\TooManyRequestsException;
use Cerberos\Moneybird\Actions\Filterable;
use Cerberos\Moneybird\Actions\FindAll;
use Cerberos\Moneybird\Actions\Synchronizable;
use Cerberos\Moneybird\Model;
use GuzzleHttp\Exception\GuzzleException;

class FinancialMutation extends Model
{
    use FindAll, Filterable, Synchronizable;

    /**
     * @see https://developer.moneybird.com/api/financial_mutations/#patch_financial_mutations_id_link_booking
     *
     * @var array
     */
    private static array $allowedBookingTypesToLinkToFinancialMutation = [
        'Document',
        'ExternalSalesInvoice',
        'LedgerAccount',
        'NewPurchaseInvoice',
        'NewReceipt',
        'Payment',
        'PaymentTransaction',
        'PaymentTransactionBatch',
        'PurchaseTransaction',
        'PurchaseTransactionBatch',
        'SalesInvoice',
    ];

    /**
     * @see https://developer.moneybird.com/api/financial_mutations/#delete_financial_mutations_id_unlink_booking
     *
     * @var array
     */
    private static array $allowedBookingTypesToUnlinkFromFinancialMutation = [
        'LedgerAccountBooking',
        'Payment',
    ];

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'amount',
        'code',
        'date',
        'message',
        'contra_account_name',
        'contra_account_number',
        'state',
        'amount_open',
        'sepa_fields',
        'batch_reference',
        'financial_account_id',
        'currency',
        'original_amount',
        'created_at',
        'updated_at',
        'financial_statement_id',
        'processed_at',
        'payments',
        'ledger_account_bookings',
        'account_servicer_transaction_id',
    ];

    /**
     * @var string
     */
    protected string $endpoint = 'financial_mutations';

    /**
     * @var array
     */
    protected array $multipleNestedEntities = [
        'ledger_account_bookings' => [
            'entity' => LedgerAccountBooking::class,
            'type'   => self::NESTING_TYPE_ARRAY_OF_OBJECTS,
        ],
    ];

    /**
     * @param string            $bookingType
     * @param int|string        $bookingId
     * @param float|string      $priceBase
     * @param float|string|null $price
     * @param string|null       $description
     * @param string|null       $paymentBatchIdentifier
     *
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function linkToBooking(
        string $bookingType,
        int|string $bookingId,
        float|string $priceBase,
        float|string $price = null,
        string $description = null,
        string $paymentBatchIdentifier = null
    ): mixed
    {
        if (!in_array($bookingType, self::$allowedBookingTypesToLinkToFinancialMutation, true)) {
            throw new ApiException('Invalid booking type to link to FinancialMutation, allowed booking types: '
                . implode(', ', self::$allowedBookingTypesToLinkToFinancialMutation));
        }

        if (!is_numeric($bookingId)) {
            throw new ApiException('Invalid Booking identifier to link to FinancialMutation');
        }

        //Filter out potential NULL values
        $parameters = array_filter([
            'booking_type'             => $bookingType,
            'booking_id'               => $bookingId,
            'price_base'               => $priceBase,
            'price'                    => $price,
            'description'              => $description,
            'payment_batch_identifier' => $paymentBatchIdentifier,
        ]);

        return $this->connection->patch($this->endpoint . '/' . $this->id . '/link_booking', json_encode($parameters));
    }

    /**
     * @param string     $bookingType
     * @param int|string $bookingId
     *
     * @return mixed
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     */
    public function unlinkFromBooking(string $bookingType, int|string $bookingId): mixed
    {
        if (!in_array($bookingType, self::$allowedBookingTypesToUnlinkFromFinancialMutation, true)) {
            throw new ApiException('Invalid booking type to unlink from FinancialMutation, allowed booking types: '
                . implode(', ', self::$allowedBookingTypesToUnlinkFromFinancialMutation));
        }

        if (!is_numeric($bookingId)) {
            throw new ApiException('Invalid Booking identifier to unlink from FinancialMutation');
        }

        $parameters = [
            'booking_type' => $bookingType,
            'booking_id'   => $bookingId,
        ];

        return $this->connection->delete($this->endpoint . '/' . $this->id . '/unlink_booking', json_encode($parameters));
    }
}
