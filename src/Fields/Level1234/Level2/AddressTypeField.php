<?php

namespace PhpTwinfield\Fields\Level1234\Level2;

use PhpTwinfield\Enums\AddressType;

trait AddressTypeField
{
    /**
     * Address type field
     * Used by: CustomerAddress, SupplierAddress
     *
     * @var AddressType|null
     */
    private $type;

    public function getType(): ?AddressType
    {
        return $this->type;
    }

    /**
     * @param AddressType|null $type
     * @return $this
     */
    public function setType(?AddressType $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string|null $typeString
     * @return $this
     * @throws Exception
     */
    public function setTypeFromString(?string $typeString)
    {
        return $this->setType(new AddressType((string)$typeString));
    }
}