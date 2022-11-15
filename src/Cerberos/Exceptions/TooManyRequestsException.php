<?php

namespace Cerberos\Exceptions;

class TooManyRequestsException extends ApiException
{
    /**
     * Moneybird Ratelimit header: RateLimit-Remaining.
     *
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public int $retryAfterNumberOfSeconds;

    /**
     * Moneybird Ratelimit header: RateLimit-Limit.
     *
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public int $currentRateLimit;

    /**
     * Moneybird Ratelimit header: RateLimit-Reset.
     *
     * @link https://developer.moneybird.com/#throttling
     *
     * @var int
     */
    public int $rateLimitResetsAfterTimestamp;
}
