<?php

namespace PhpTwinfield\Fields\Level1234;

trait GeneralLedgerBeginPeriodField
{
    /**
     * General ledger begin period field
     * Used by: Customer, GeneralLedger, Supplier
     *
     * @var int|null
     */
    private $beginPeriod;

    /**
     * @return null|int
     */
    public function getBeginPeriod(): ?int
    {
        return $this->beginPeriod;
    }

    /**
     * @param null|int $beginPeriod
     * @return $this
     */
    public function setBeginPeriod(?int $beginPeriod): self
    {
        $this->beginPeriod = $beginPeriod;
        return $this;
    }
}