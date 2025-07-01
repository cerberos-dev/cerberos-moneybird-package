<?php

namespace Unit;

use Cerberos\Exceptions\ApiException;
use Cerberos\Exceptions\TooManyRequestsException;
use Cerberos\Moneybird\Connection;
use Cerberos\Moneybird\Moneybird;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiTest.
 *
 * Sets up a mocked Connection object. Each test case:
 *  - indicates what the mocked Connection object should expect when interacting with the Client / Entities
 *  - actually interact with the Client / Entities
 */
class ApiTest extends TestCase
{
    /**
     * @var Moneybird
     */
    private Moneybird $client;

    /**
     * @var Connection
     */
    private MockObject $connection;

    /**
     * Same as self::$connection, only differently typed to enable autocompletion in IDE.
     *
     * @var MockObject
     */
    private MockObject $mockedConnection;

    protected function setUp(): void
    {
        $this->connection = $this->getMockBuilder(Connection::class)->getMock();
        $this->connection->setTesting(true);
        $this->mockedConnection = $this->connection;
        $this->client = new Moneybird($this->connection);
    }

    public function testConnectionIsProperlyMocked(): void
    {
        $this->assertInstanceOf(Connection::class, $this->connection);
    }

    public function testTestModeIsProperlySet(): void
    {
        $this->mockedConnection->expects($this->once())
            ->method('isTesting')
            ->will($this->returnValue(true));

        $this->assertTrue($this->connection->isTesting());
    }

    public function testSetAdministrationIdSet(): void
    {
        $administrationId = 123456789;

        $this->mockedConnection->expects($this->once())
            ->method('setAdministrationId')
            ->with($administrationId);

        $this->connection->setAdministrationId($administrationId);
    }

    /**
     * @throws ApiException
     * @throws TooManyRequestsException
     * @throws GuzzleException
     */
    public function testFindAllWebHooksTriggersHttpGet(): void
    {
        $attributes = [
            'url' => 'https://www.domain.ext',
        ];

        $this->mockedConnection->expects($this->once())
            ->method('get')
            ->will($this->returnValue($attributes));

        $webHook = $this->client->webhook($attributes);
        $webHook->get();
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     */
    public function testStoreWebHookTriggersHttpPost(): void
    {
        $attributes = [
            'url' => 'https://www.domain.ext',
        ];

        $this->mockedConnection->expects($this->once())
            ->method('post')
            ->will($this->returnValue($attributes));

        $webHook = $this->client->webhook($attributes);
        $webHook->save();
    }

    public function testFinancialMutationLinkToBooking(): void
    {
        $financialMutationId = 1;
        $bookingType = 'LedgerAccount';
        $bookingId = 100;
        $priceBase = 100.00;
        $parameters = [
            'booking_type' => $bookingType,
            'booking_id'   => $bookingId,
            'price_base'   => $priceBase,
        ];
        $httpResponseCode = 200;

        $this->mockedConnection->expects($this->once())
            ->method('patch')
            ->with('financial_mutations/' . $financialMutationId . '/link_booking', json_encode($parameters))
            ->will($this->returnValue($httpResponseCode));

        $financialMutation = $this->client->financialMutation();
        $financialMutation->id = $financialMutationId;

        $this->assertEquals($httpResponseCode, $financialMutation->linkToBooking($bookingType, $bookingId, $priceBase));
    }

    public function testFinancialMutationUnlinkFromBooking(): void
    {
        $financialMutationId = 1;
        $bookingType = 'LedgerAccountBooking';
        $bookingId = 100;
        $parameters = [
            'booking_type' => $bookingType,
            'booking_id'   => $bookingId,
        ];
        $response = [];

        $this->mockedConnection->expects($this->once())
            ->method('delete')
            ->with('financial_mutations/' . $financialMutationId . '/unlink_booking', json_encode($parameters))
            ->will($this->returnValue($response));

        $financialMutation = $this->client->financialMutation();
        $financialMutation->id = $financialMutationId;

        $this->assertEquals($response, $financialMutation->unlinkFromBooking($bookingType, $bookingId));
    }
}
