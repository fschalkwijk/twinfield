<?php

namespace PhpTwinfield\UnitTests;

use PhpTwinfield\ApiConnectors\InvoiceApiConnector;
use PhpTwinfield\Invoice;
use PhpTwinfield\Response\Response;
use PhpTwinfield\Secure\AuthenticatedConnection;
use PhpTwinfield\Services\ProcessXmlService;
use PHPUnit\Framework\TestCase;

class InvoiceApiConnectorTest extends TestCase
{
    /**
     * @var InvoiceApiConnector
     */
    protected $apiConnector;

    /**
     * @var ProcessXmlService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $processXmlService;

    protected function setUp()
    {
        parent::setUp();

        $this->processXmlService = $this->getMockBuilder(ProcessXmlService::class)
            ->setMethods(["sendDocument"])
            ->disableOriginalConstructor()
            ->getMock();

        /** @var AuthenticatedConnection|\PHPUnit_Framework_MockObject_MockObject $connection */
        $connection = $this->createMock(AuthenticatedConnection::class);
        $connection
            ->expects($this->any())
            ->method("getAuthenticatedClient")
            ->willReturn($this->processXmlService);

        $this->apiConnector = new InvoiceApiConnector($connection);
    }

    private function createInvoice(): Invoice
    {
        $invoice = new Invoice();
        return $invoice;
    }

    public function testSendAllReturnsMappedObjects()
    {
        $response = Response::fromString(file_get_contents(
            __DIR__."/resources/invoice-response.xml"
        ));

        $this->processXmlService->expects($this->once())
            ->method("sendDocument")
            ->willReturn($response);

        $invoice = $this->createInvoice();

        $mapped = $this->apiConnector->send($invoice);

        $this->assertInstanceOf(Invoice::class, $mapped);
        $this->assertEquals("10", $mapped->getInvoiceNumber());
        $this->assertEquals("20190410", $mapped->getInvoiceDateToString());
    }
}