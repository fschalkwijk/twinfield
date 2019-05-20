<?php

namespace PhpTwinfield;

use PhpTwinfield\Fields\DueDateField;
use PhpTwinfield\Fields\Transaction\InvoiceNumberField;
use PhpTwinfield\Fields\Transaction\InvoiceNumberRaiseWarningField;
use PhpTwinfield\Fields\Transaction\OriginReferenceField;
use PhpTwinfield\Fields\Transaction\PaymentReferenceField;
use PhpTwinfield\SalesTransactionLine;

/*
 * @link https://c3.twinfield.com/webservices/documentation/#/ApiReference/SalesTransactions
 */
class SalesTransaction extends BaseTransaction
{
    use DueDateField;
    use InvoiceNumberField;
    use InvoiceNumberRaiseWarningField;
    use OriginReferenceField;
    use PaymentReferenceField;

    /*
     * @return string
     */
    public function getLineClassName(): string
    {
        return SalesTransactionLine::class;
    }

    /*
     * @param SalesTransactionLine $line
     * @return $this
     */
    public function addLine(SalesTransactionLine $line)
    {
        parent::addLine($line);

        return $this;
    }
}
