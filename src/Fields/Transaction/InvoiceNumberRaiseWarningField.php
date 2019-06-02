<?php

namespace PhpTwinfield\Fields\Transaction;

trait InvoiceNumberRaiseWarningField
{
    /**
     * Invoice number raise warning field
     * Used by: PurchaseTransaction, SalesTransaction
     *
     * @var bool
     */
    private $invoiceNumberRaiseWarning;

    /**
     * @return bool
     */
    public function getInvoiceNumberRaiseWarning(): ?bool
    {
        return $this->invoiceNumberRaiseWarning;
    }

    public function getInvoiceNumberRaiseWarningToString(): ?string
    {
        return ($this->getInvoiceNumberRaiseWarning()) ? 'true' : 'false';
    }

    /**
     * @param bool $invoiceNumberRaiseWarning
     * @return $this
     */
    public function setInvoiceNumberRaiseWarning(?bool $invoiceNumberRaiseWarning): self
    {
        $this->invoiceNumberRaiseWarning = $invoiceNumberRaiseWarning;
        return $this;
    }

    /**
     * @param string|null $invoiceNumberRaiseWarningString
     * @return $this
     * @throws Exception
     */
    public function setInvoiceNumberRaiseWarningFromString(?string $invoiceNumberRaiseWarningString)
    {
        return $this->setInvoiceNumberRaiseWarning(filter_var($invoiceNumberRaiseWarningString, FILTER_VALIDATE_BOOLEAN));
    }
}