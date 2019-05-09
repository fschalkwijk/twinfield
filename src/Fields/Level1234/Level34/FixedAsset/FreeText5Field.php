<?php

namespace PhpTwinfield\Fields\Level1234\Level34\FixedAsset;

trait FreeText5Field
{
    /**
     * Free text 5 field
     * Used by: FixedAssetFixedAssets
     *
     * @var string|null
     */
    private $freeText5;

    /**
     * @return null|string
     */
    public function getFreetext5(): ?string
    {
        return $this->freeText5;
    }

    /**
     * @param null|string $freeText5
     * @return $this
     */
    public function setFreetext5(?string $freeText5): self
    {
        $this->freeText5 = $freeText5;
        return $this;
    }
}