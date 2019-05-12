<?php

namespace PhpTwinfield\Fields\VatCode;

use PhpTwinfield\VatGroup;

/**
 * The VAT group
 * Used by: VatCodeAccount
 *
 * @package PhpTwinfield\Traits
 */
trait GroupField
{
    /**
     * @var VatGroup|null
     */
    private $group;

    public function getGroup(): ?VatGroup
    {
        return $this->group;
    }

    public function getGroupToString(): ?string
    {
        if ($this->getGroup() != null) {
            return $this->group->getCode();
        } else {
            return null;
        }
    }

    /**
     * @return $this
     */
    public function setGroup(?VatGroup $group): self
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @param string|null $groupCode
     * @return $this
     * @throws Exception
     */
    public function setGroupFromString(?string $groupCode)
    {
        $group = new VatGroup();
        $group->setCode($groupCode);
        return $this->setGroup($group);
    }
}