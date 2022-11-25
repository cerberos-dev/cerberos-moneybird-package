<?php

namespace Cerberos\Moneybird\Entities\SalesInvoice;

use DateTime;
use InvalidArgumentException;
use JsonSerializable;

class SendInvoiceOptions implements JsonSerializable
{
    const METHOD_EMAIL             = 'Email';
    const METHOD_SIMPLER_INVOICING = 'Simplerinvoicing';
    const METHOD_POST              = 'Post';
    const METHOD_MANUAL            = 'Manual';

    /**
     * @var string
     */
    private string $method;

    /**
     * @var string|null
     */
    private ?string $emailAddress;

    /**
     * @var string|null
     */
    private ?string $emailMessage;

    /**
     * If set to true, the e-mail is scheduled for the given $scheduleDate
     * By default it is false meaning the mail is sent immediately.
     *
     * @var bool
     */
    private ?bool $scheduled = null;

    /**
     * @var mixed|null
     */
    private mixed $scheduleDate = null;

    /** Undocumented boolean properties */

    /**
     * @var bool|null
     */
    private ?bool $mergeable = null;

    /**
     * @var bool|null
     */
    private ?bool $deliverUbl = null;

    /**
     * @param $deliveryMethod
     * @param $emailAddress
     * @param $emailMessage
     */
    public function __construct($deliveryMethod = null, $emailAddress = null, $emailMessage = null)
    {
        $this->setMethod($deliveryMethod ?: self::METHOD_EMAIL);
        $this->setEmailAddress($emailAddress);
        $this->setEmailMessage($emailMessage);
    }

    /**
     * @return string[]
     */
    private static function getValidMethods(): array
    {
        // TODO move this to a private const VALID_METHODS when php 7 is supported
        return [
            self::METHOD_EMAIL,
            self::METHOD_SIMPLER_INVOICING,
            self::METHOD_POST,
            self::METHOD_MANUAL,
        ];
    }

    /**
     * @param DateTime $date
     *
     * @return void
     */
    public function schedule(DateTime $date): void
    {
        $this->scheduleDate = $date;
        $this->scheduled = true;
    }

    /**
     * @return bool
     */
    public function isScheduled(): bool
    {
        return $this->scheduled === true;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return array_filter([
            'delivery_method'   => $this->getMethod(),
            'sending_scheduled' => $this->isScheduled() ?: null,
            'deliver_ubl'       => $this->getDeliverUbl(),
            'mergeable'         => $this->getMergeable(),
            'email_address'     => $this->getEmailAddress(),
            'email_message'     => $this->getEmailMessage(),
            'invoice_date'      => $this->getScheduleDate() ? $this->getScheduleDate()->format('Y-m-d') : null,
        ], function ($item) {
            return $item !== null;
        });
    }

    /**
     * @return mixed
     */
    public function getScheduleDate(): mixed
    {
        return $this->scheduleDate;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return void
     */
    public function setMethod(string $method): void
    {
        $validMethods = self::getValidMethods();

        if (!in_array($method, $validMethods)) {
            $method = is_object($method) ? get_class($method) : $method;

            $validMethodNames = implode(',', $validMethods);

            throw new InvalidArgumentException("Invalid method: '$method'. Expected one of: '$validMethodNames'");
        }

        $this->method = $method;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * @param string|null $emailAddress
     *
     * @return void
     */
    public function setEmailAddress(string|null $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string|null
     */
    public function getEmailMessage(): ?string
    {
        return $this->emailMessage;
    }

    /**
     * @param string|null $emailMessage
     *
     * @return void
     */
    public function setEmailMessage(string|null $emailMessage): void
    {
        $this->emailMessage = $emailMessage;
    }

    /**
     * @return bool|null
     */
    public function getMergeable(): ?bool
    {
        return $this->mergeable;
    }

    /**
     * @param bool $mergeable
     *
     * @return void
     */
    public function setMergeable(bool $mergeable): void
    {
        $this->mergeable = $mergeable;
    }

    /**
     * @return bool|null
     */
    public function getDeliverUbl(): ?bool
    {
        return $this->deliverUbl;
    }

    /**
     * @param bool $deliverUbl
     *
     * @return void
     */
    public function setDeliverUbl(bool $deliverUbl): void
    {
        $this->deliverUbl = $deliverUbl;
    }
}
