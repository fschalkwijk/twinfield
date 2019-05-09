<?php

namespace PhpTwinfield\Fields\Level1234;

trait LevelField
{
    /**
     * Level field
     * Used by: CustomerChildValidation, CustomerFinancials, FixedAssetFinancials, GeneralLedgerChildValidation, GeneralLedgerFinancials, SupplierChildValidation, SupplierFinancials
     *
     * @var int|null
     */
    private $level;

    /**
     * @return null|int
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * @param null|int $level
     * @return $this
     */
    public function setLevel(?int $level): self
    {
        $this->level = $level;
        return $this;
    }
}