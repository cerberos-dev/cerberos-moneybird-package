<?php

namespace CerberosTest\Financials\Moneybird\Entities;

use Cerberos\Exceptions\ApiException;
use Cerberos\Moneybird\Connection;
use Cerberos\Moneybird\Entities\SalesInvoice;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument\Token\AnyValueToken;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use stdClass;

class SalesInvoiceTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var SalesInvoice
     */
    private SalesInvoice $salesInvoice;

    /**
     * @var ObjectProphecy
     */
    private ObjectProphecy $connection;

    /**
     * @var ObjectProphecy
     */
    private ObjectProphecy $options;

    /**
     * @var array
     */
    private array $optionsJson;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->prophesize(Connection::class);
        $this->options = $this->prophesize(SalesInvoice\SendInvoiceOptions::class);
        $this->optionsJson = [
            'my-key' => 'my value',
        ];
        $this->options->jsonSerialize()->willReturn($this->optionsJson);

        $this->salesInvoice = new SalesInvoice($this->connection->reveal());
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     */
    public function testSendInvoiceThrowsExceptionWhenNonOptionsPassed()
    {
        try {
            $this->salesInvoice->sendInvoice(false);

            self::fail('Should have thrown exception');
        } catch (InvalidArgumentException $e) {
            $this->addToAssertionCount(1);
        }

        try {
            $this->salesInvoice->sendInvoice(new stdClass());

            self::fail('Should have thrown exception');
        } catch (InvalidArgumentException $e) {
            $this->addToAssertionCount(1);
        }
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     */
    public function testSendWithoutArguments()
    {
        $this->markTestSkipped();
        $this->connection->patch(new AnyValueToken(), json_encode([
            'sales_invoice_sending' => [
                'delivery_method' => SalesInvoice\SendInvoiceOptions::METHOD_EMAIL,
            ],
        ]))->shouldBeCalled();

        $this->salesInvoice->sendInvoice();
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     */
    public function testSendWithMethodAsString()
    {
        $this->markTestSkipped();
        $this->connection->patch(new AnyValueToken(), json_encode([
            'sales_invoice_sending' => [
                'delivery_method' => SalesInvoice\SendInvoiceOptions::METHOD_EMAIL,
            ],
        ]))->shouldBeCalled();

        $this->salesInvoice->sendInvoice(SalesInvoice\SendInvoiceOptions::METHOD_EMAIL);
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     */
    public function testSendWithOptionsObject()
    {
        $this->markTestSkipped();
        $this->connection->patch(new AnyValueToken(), json_encode([
            'sales_invoice_sending' => $this->optionsJson,
        ]))->shouldBeCalled();

        $this->salesInvoice->sendInvoice($this->options->reveal());
    }
}
