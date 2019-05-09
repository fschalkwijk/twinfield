<?php

namespace PhpTwinfield\Fields;

use PhpTwinfield\Rate;

/**
 * The rate
 * Used by: ActivityProjects, ActivityQuantity, ProjectProjects, ProjectQuantity, RateRateChange
 *
 * @package PhpTwinfield\Traits
 */
trait RateField
{
    /**
     * @var Rate|null
     */
    private $rate;

    public function getRate(): ?Rate
    {
        return $this->rate;
    }

    public function getRateToCode(): ?string
    {
        if ($this->getRate() != null) {
            return $this->rate->getCode();
        } else {
            return null;
        }
    }

    /**
     * @return $this
     */
    public function setRate(?Rate $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @param string|null $rateCode
     * @return $this
     * @throws Exception
     */
    public function setRateFromCode(?string $rateCode)
    {
        $rate = new Rate();
        $rate->setCode($rateCode);
        return $this->setRate($rate);
    }
}