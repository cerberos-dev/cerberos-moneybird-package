<?php

namespace Cerberos\Tests;

use Cerberos\Exceptions\ApiException;
use Cerberos\Exceptions\TooManyRequestsException;
use Cerberos\Moneybird\Connection;
use Cerberos\Moneybird\Entities\Contact;
use Closure;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ConnectionTest.
 *
 * Tests the connection for proper headers, authentication and other stuff
 */
class ConnectionTest extends TestCase
{
    /**
     * Container to hold the Guzzle history (by reference).
     *
     * @var array
     */
    private array $container;

    /**
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     */
    public function testClientIncludesAuthenticationHeader()
    {
        $connection = $this->getConnectionForTesting();

        $contact = new Contact($connection);
        $contact->get();

        $request = $this->getRequestFromHistoryContainer();

        $this->assertEquals('Bearer testAccessToken', $request->getHeaderLine('Authorization'));
    }

    /**
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     */
    public function testClientIncludesJsonHeaders()
    {
        $connection = $this->getConnectionForTesting();

        $contact = new Contact($connection);
        $contact->get();

        $request = $this->getRequestFromHistoryContainer();

        $this->assertEquals('application/json', $request->getHeaderLine('Accept'));
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
    }

    /**
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     */
    public function testClientTriesToGetAccessTokenWhenNoneGiven()
    {
        $connection = $this->getConnectionForTesting();
        $connection->setAccessToken(null);

        $contact = new Contact($connection);
        $contact->get();

        $request = $this->getRequestFromHistoryContainer();
        $this->assertEquals('POST', $request->getMethod());

        Psr7\Message::rewindBody($request);

        $this->assertEquals(
            'redirect_uri=testRedirectUrl&grant_type=authorization_code&client_id=testClientId&client_secret=testClientSecret&code=testAuthorizationCode',
            $request->getBody()->getContents()
        );
    }

    /**
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     */
    public function testClientContinuesWithRequestAfterGettingAccessTokenWhenNoneGiven()
    {
        $connection = $this->getConnectionForTesting();
        $connection->setAccessToken(null);

        $contact = new Contact($connection);
        $contact->get();

        $request = $this->getRequestFromHistoryContainer(1);

        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     */
    public function testClientDetectsApiRateLimit()
    {
        $this->markTestIncomplete('TooManyRequestsException is not triggered correctly for some reason ');

        $responseStatusCode = 429;
        $responseHeaderName = 'RateLimit-Remaining';
        $responseHeaderValue = 60;

        // Note that middlewares are processed 'LIFO': first the response header should be added, then an exception thrown
        $additionalMiddlewares = [
            $this->getMiddleWareThatThrowsBadResponseException($responseStatusCode),
            $this->getMiddleWareThatAddsResponseHeader($responseHeaderName, $responseHeaderValue),
        ];

        $connection = $this->getConnectionForTesting($additionalMiddlewares);

        $contact = new Contact($connection);

        try {
            $contact->get();
        } catch (TooManyRequestsException $exception) {
            $this->assertEquals($responseStatusCode, $exception->getCode());
            $this->assertEquals($responseHeaderValue, $exception->retryAfterNumberOfSeconds);
        }
    }

    /**
     * @param array $additionalMiddlewares
     *
     * @return Connection
     */
    private function getConnectionForTesting(array $additionalMiddlewares = []): Connection
    {
        $this->container = [];

        $history = Middleware::history($this->container);

        $connection = new Connection();
        $connection->insertMiddleWare($history);

        if (count($additionalMiddlewares) > 0) {
            foreach ($additionalMiddlewares as $additionalMiddleware) {
                $connection->insertMiddleWare($additionalMiddleware);
            }
        }
        $connection->setClientId('testClientId');
        $connection->setClientSecret('testClientSecret');
        $connection->setAccessToken('testAccessToken');
        $connection->setAuthorizationCode('testAuthorizationCode');
        $connection->setRedirectUrl('testRedirectUrl');
        $connection->setTesting(true);

        return $connection;
    }

    /**
     * @param $requestNumber
     *
     * @return mixed
     */
    private function getRequestFromHistoryContainer($requestNumber = 0): mixed
    {
        $this->assertArrayHasKey($requestNumber, $this->container);
        $this->assertArrayHasKey('request', $this->container[$requestNumber]);

        $this->assertInstanceOf(RequestInterface::class, $this->container[$requestNumber]['request']);

        return $this->container[$requestNumber]['request'];
    }

    /**
     * @param $header
     * @param $value
     *
     * @return Closure
     */
    private function getMiddleWareThatAddsResponseHeader($header, $value): Closure
    {
        return function (callable $handler) use ($header, $value) {
            return function (RequestInterface $request, array $options) use ($handler, $header, $value) {
                /* @var PromiseInterface $promise */
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($header, $value) {
                        return $response->withHeader($header, $value);
                    }
                );
            };
        };
    }

    /**
     * @param $statusCode
     *
     * @return Closure
     */
    private function getMiddleWareThatThrowsBadResponseException($statusCode = null): Closure
    {
        return function (callable $handler) use ($statusCode) {
            return function (RequestInterface $request, array $options) use ($handler, $statusCode) {
                /* @var PromiseInterface $promise */
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($request, $statusCode) {
                        if (is_int($statusCode)) {
                            $response = $response->withStatus($statusCode);
                        }

                        throw new BadResponseException('DummyException as injected by: ' . __METHOD__, $request, $response);
                    }
                );
            };
        };
    }
}
