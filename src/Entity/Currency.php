<?php

namespace Keet\Country\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Keet\Mvc\Entity\AbstractEntity;
use Keet\Mvc\Traits\EnabledTrait;

/**
 * Class Currency
 * @package Keet\Country\Entity
 *
 * Setup for ISO 4217 standard. Includes
 * - Name
 * - Code (3 letter string (a.k.a. alpha 3)
 * - Numeric (numerical representation of currency, by ISO 4217 standard)
 * - Decimals (after separator)
 *
 * Properties linked to Country entity for related ISO standardized data.
 *
 * @ORM\Entity(repositoryClass="Keet\Country\Repository\CurrencyRepository")
 * @ORM\Table(name="country_currencies")
 */
class Currency extends AbstractEntity
{
    use EnabledTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=3, nullable=false, unique=true)
     */
    protected $code;

    /**
     * @var int
     * @ORM\Column(name="`numeric`", type="integer", length=3, nullable=false, unique=true)
     */
    protected $numeric;

    /**
     * Amount of decimals after separator
     *
     * @var int
     * @ORM\Column(name="decimals", type="integer", length=1, nullable=true)
     */
    protected $decimals = 0;

    /**
     * @var Collection|ArrayCollection|Currency[]
     * @ORM\ManyToMany(targetEntity="Keet\Country\Entity\Country", mappedBy="currencies")
     */
    protected $countries;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Currency
     */
    public function setName(string $name) : Currency
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode() : ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Currency
     */
    public function setCode(string $code) : Currency
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumeric() : ?int
    {
        return $this->numeric;
    }

    /**
     * @param int $numeric
     *
     * @return Currency
     */
    public function setNumeric(int $numeric) : Currency
    {
        $this->numeric = $numeric;

        return $this;
    }

    /**
     * @return int
     */
    public function getDecimals() : ?int
    {
        return $this->decimals;
    }

    /**
     * @param int $decimals
     *
     * @return Currency
     */
    public function setDecimals(int $decimals) : Currency
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * @return Collection|ArrayCollection|Country[]
     */
    public function getCountries() : Collection
    {
        return $this->countries;
    }

    /**
     * @param Collection|ArrayCollection|Country[] $countries
     * @return $this
     */
    public function addCountries(Collection $countries): Currency
    {
        foreach ($countries as $country) {
            if (!$this->countries->contains($country)) {
                $this->countries->add($country);
            }

            if (!$country->getCurrencies()->contains($this)) {
                $country->getCurrencies()->add($this);
            }
        }

        return $this;
    }

    /**
     * @param Collection|ArrayCollection|Country[] $countries
     * @return $this
     */
    public function removeCountries(Collection $countries): Currency
    {
        foreach ($countries as $country) {
            if ($this->countries->contains($country)) {
                $this->countries->removeElement($country);
            }

            if ($country->getCurrencies()->contains($this)) {
                $country->getCurrencies()->removeElement($this);
            }
        }

        return $this;
    }

}