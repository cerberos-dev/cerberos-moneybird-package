<?php

namespace Cerberos\Moneybird;

use Cerberos\Exceptions\ApiException;
use Cerberos\Exceptions\TooManyRequestsException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Connection
{
    /**
     * @var string
     */
    protected string $authorizationCode;

    /**
     * @var int|string
     */
    protected int|string $administrationId;

    /**
     * @var array Middlewares for the Guzzle 6 client
     */
    protected array $middleWares = [];

    /**
     * @var string
     */
    private string $apiUrl = 'https://moneybird.com/api/v2';

    /**
     * @var string
     */
    private string $authUrl = 'https://moneybird.com/oauth/authorize';

    /**
     * @var string
     */
    private string $tokenUrl = 'https://moneybird.com/oauth/token';

    /**
     * @var int|string
     */
    private int|string $clientId;

    /**
     * @var mixed
     */
    private mixed $clientSecret;

    /**
     * @var mixed
     */
    private mixed $accessToken;

    /**
     * @var mixed
     */
    private mixed $refreshToken;

    /**
     * @var mixed
     */
    private mixed $redirectUrl;

    /**
     * @var Client|null
     */
    private ?Client $client = null;

    /**
     * @var bool
     */
    private bool $testing = false;

    /**
     * @var array
     */
    private array $scopes = [];

    /**
     * Insert a custom Guzzle client.
     *
     * @param Client $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * Insert a Middleware for the Guzzle Client.
     *
     * @param $middleWare
     */
    public function insertMiddleWare($middleWare): void
    {
        $this->middleWares[] = $middleWare;
    }

    /**
     * @return Client
     * @throws ApiException
     * @throws GuzzleException
     */
    public function connect(): Client
    {
        // If access token is not set or token has expired, acquire new token
        if (empty($this->accessToken)) {
            $this->acquireAccessToken();
        }

        $client = $this->client();

        return $client;
    }

    /**
     * @param string $url
     * @param array  $params
     * @param bool   $fetchAll
     *
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function get(string $url, array $params = [], bool $fetchAll = false): mixed
    {
        try {
            $request = $this->createRequest('GET', $this->formatUrl($url, 'get'), null, $params);
            $response = $this->client()->send($request);

            $json = $this->parseResponse($response);

            if ($fetchAll === true) {
                if ($nextParams = $this->getNextParams($response->getHeaderLine('Link'))) {
                    $json = array_merge($json, $this->get($url, $nextParams, $fetchAll));
                }
            }

            return $json;
        } catch (Exception $exception) {
            throw $this->parseExceptionForErrorMessages($exception);
        }
    }

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function post(string $url, string $body): mixed
    {
        try {
            $request = $this->createRequest('POST', $this->formatUrl($url, 'post'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $exception) {
            throw $this->parseExceptionForErrorMessages($exception);
        }
    }

    /**
     * @param string $url
     * @param string $body
     *
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     */
    public function patch(string $url, string $body): mixed
    {
        try {
            $request = $this->createRequest('PATCH', $this->formatUrl($url, 'patch'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param        $body
     *
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     * @throws TooManyRequestsException
     */
    public function delete(string $url, $body = null): mixed
    {
        try {
            $request = $this->createRequest('DELETE', $this->formatUrl($url, 'delete'), $body);
            $response = $this->client()->send($request);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            throw $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return ResponseInterface|void
     * @throws GuzzleException
     * @throws TooManyRequestsException
     */
    public function download(string $url, array $options = [])
    {
        try {
            $request = $this->createRequestNoJson('GET', $this->formatUrl($url, 'get'), null);

            return $this->client()->send($request, $options);
        } catch (Exception $e) {
            $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return mixed|void
     * @throws GuzzleException
     * @throws TooManyRequestsException
     */
    public function upload(string $url, array $options)
    {
        try {
            $request = $this->createRequestNoJson('POST', $this->formatUrl($url, 'post'), null);

            $response = $this->client()->send($request, $options);

            return $this->parseResponse($response);
        } catch (Exception $e) {
            $this->parseExceptionForErrorMessages($e);
        }
    }

    /**
     * @return string
     */
    public function getAuthUrl(): string
    {
        return $this->authUrl . '?' . http_build_query([
                'client_id'     => $this->clientId,
                'redirect_uri'  => $this->redirectUrl,
                'response_type' => 'code',
                'scope'         => $this->scopes ? implode(' ', $this->scopes) : 'sales_invoices documents estimates bank time_entries settings',
            ]);
    }

    /**
     * @param int|string $clientId
     *
     * @return void
     */
    public function setClientId(int|string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @param mixed $clientSecret
     *
     * @return void
     */
    public function setClientSecret(mixed $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param string $authorizationCode
     *
     * @return void
     */
    public function setAuthorizationCode(string $authorizationCode): void
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * @return void
     */
    public function redirectForAuthorization(): void
    {
        $authUrl = $this->getAuthUrl();

        header('Location: ' . $authUrl);
        exit;
    }

    /**
     * @param mixed $redirectUrl
     *
     * @return void
     */
    public function setRedirectUrl(mixed $redirectUrl): void
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return bool
     */
    public function needsAuthentication(): bool
    {
        return empty($this->authorizationCode);
    }

    /**
     * @return mixed
     */
    public function getAccessToken(): mixed
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     */
    public function setAccessToken(mixed $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken(): mixed
    {
        return $this->refreshToken;
    }

    /**
     * @return string
     */
    public function getAdministrationId(): string
    {
        return $this->administrationId;
    }

    /**
     * @param int|string $administrationId
     *
     * @return void
     */
    public function setAdministrationId(int|string $administrationId): void
    {
        $this->administrationId = $administrationId;
    }

    /**
     * @param int|string $administrationId
     *
     * @return Connection
     */
    public function withAdministrationId(int|string $administrationId): Connection
    {
        $clone = clone $this;
        $clone->administrationId = $administrationId;

        return $clone;
    }

    /**
     * @return Connection
     */
    public function withoutAdministrationId(): Connection
    {
        $clone = clone $this;
        $clone->administrationId = null;

        return $clone;
    }

    /**
     * @return bool
     */
    public function isTesting(): bool
    {
        return $this->testing;
    }

    /**
     * @param bool $testing
     */
    public function setTesting(bool $testing): void
    {
        $this->testing = $testing;
    }

    /**
     * @return string
     */
    public function getTokenUrl(): string
    {
        if ($this->testing) {
            return 'https://httpbin.org/post';
        }

        return $this->tokenUrl;
    }

    /**
     * @param array $scopes
     */
    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @return Client
     */
    private function client(): Client
    {
        if ($this->client) {
            return $this->client;
        }

        $handlerStack = HandlerStack::create();

        foreach ($this->middleWares as $middleWare) {
            $handlerStack->push($middleWare);
        }

        $this->client = new Client([
            'http_errors' => true,
            'handler'     => $handlerStack,
            'expect'      => false,
        ]);

        return $this->client;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param        $body
     * @param array  $params
     * @param array  $headers
     *
     * @return Request
     * @throws ApiException
     * @throws GuzzleException
     */
    private function createRequest(string $method = 'GET', string $endpoint = '', $body = null, array $params = [], array $headers = []): Request
    {
        // Add default json headers to the request
        $headers = array_merge($headers, [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ]);

        // If access token is not set or token has expired, acquire new token
        if (empty($this->accessToken)) {
            $this->acquireAccessToken();
        }

        // If we have a token, sign the request
        if (!empty($this->accessToken)) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        // Create param string
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        // Create the request
        $request = new Request($method, $endpoint, $headers, $body);

        return $request;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param        $body
     * @param array  $params
     * @param array  $headers
     *
     * @return Request
     * @throws ApiException
     * @throws GuzzleException
     */
    private function createRequestNoJson(string $method = 'GET', string $endpoint = '', $body = null, array $params = [], array $headers = []): Request
    {
        // If access token is not set or token has expired, acquire new token
        if (empty($this->accessToken)) {
            $this->acquireAccessToken();
        }

        // If we have a token, sign the request
        if (!empty($this->accessToken)) {
            $headers['Authorization'] = 'Bearer ' . $this->accessToken;
        }

        // Create param string
        if (!empty($params)) {
            $endpoint .= '?' . http_build_query($params);
        }

        // Create the request
        return new Request($method, $endpoint, $headers, $body);
    }

    /**
     * @param Response $response
     *
     * @return mixed
     *
     * @throws ApiException
     */
    private function parseResponse(Response $response): mixed
    {
        try {
            Psr7\Message::rewindBody($response);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\RuntimeException $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * @param $headerLine
     *
     * @return bool|array
     */
    private function getNextParams($headerLine): bool|array
    {
        $links = Psr7\Header::parse($headerLine);

        foreach ($links as $link) {
            if (isset($link['rel']) && $link['rel'] === 'next') {
                $query = parse_url(trim($link[0], '<>'), PHP_URL_QUERY);

                parse_str($query, $params);

                return $params;
            }
        }

        return false;
    }

    /**
     * @return void
     * @throws ApiException
     * @throws GuzzleException
     */
    private function acquireAccessToken(): void
    {
        $body = [
            'form_params' => [
                'redirect_uri'  => $this->redirectUrl,
                'grant_type'    => 'authorization_code',
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code'          => $this->authorizationCode,
            ],
        ];

        $response = $this->client()->post($this->getTokenUrl(), $body);

        if ($response->getStatusCode() == 200) {
            Psr7\Message::rewindBody($response);

            $body = json_decode($response->getBody()->getContents(), true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $this->accessToken = array_key_exists('access_token', $body) ? $body['access_token'] : null;
                $this->refreshToken = array_key_exists('refresh_token', $body) ? $body['refresh_token'] : null;
            } else {
                throw new ApiException('Could not acquire tokens, json decode failed. Got response: ' . $response->getBody()->getContents());
            }
        } else {
            throw new ApiException('Could not acquire or refresh tokens');
        }
    }

    /**
     * @param Exception $exception
     *
     * @return ApiException
     * @throws TooManyRequestsException
     */
    private function parseExceptionForErrorMessages(Exception $exception): ApiException
    {
        if (!$exception instanceof BadResponseException) {
            return new ApiException($exception->getMessage(), 0, $exception);
        }

        $response = $exception->getResponse();

        Psr7\Message::rewindBody($response);

        $responseBody = $response->getBody()->getContents();
        $decodedResponseBody = json_decode($responseBody, true);

        if (null !== $decodedResponseBody && isset($decodedResponseBody['error']['message']['value'])) {
            $errorMessage = $decodedResponseBody['error']['message']['value'];
        } else {
            $errorMessage = $responseBody;
        }

        $this->checkWhetherRateLimitHasBeenReached($response, $errorMessage);

        return new ApiException('Error ' . $response->getStatusCode() . ': ' . $errorMessage, $response->getStatusCode(), $exception);
    }

    /**
     * @param ResponseInterface $response
     * @param string            $errorMessage
     *
     * @return void
     * @throws TooManyRequestsException
     */
    private function checkWhetherRateLimitHasBeenReached(ResponseInterface $response, string $errorMessage): void
    {
        $rateLimitRemainingHeaders = $response->getHeader('RateLimit-Remaining');

        if ($response->getStatusCode() === 429 && count($rateLimitRemainingHeaders) > 0) {
            $exception = new TooManyRequestsException('Error ' . $response->getStatusCode() . ': ' . $errorMessage, $response->getStatusCode());
            $exception->retryAfterNumberOfSeconds = (int) current($rateLimitRemainingHeaders);
            $exception->currentRateLimit = (int) $response->getHeader('RateLimit-Limit');
            $exception->rateLimitResetsAfterTimestamp = (int) $response->getHeader('RateLimit-Reset');

            throw $exception;
        }
    }

    /**
     * @param string $url
     * @param string $method
     *
     * @return string
     */
    private function formatUrl(string $url, string $method = 'get'): string
    {
        if ($this->testing) {
            return 'https://httpbin.org/' . $method;
        }

        return $this->apiUrl . '/' . ($this->administrationId ? $this->administrationId . '/' : '') . $url . '.json';
    }
}
