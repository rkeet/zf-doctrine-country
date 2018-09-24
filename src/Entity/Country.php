<?php

namespace Keet\Country\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Keet\Mvc\Entity\AbstractEntity;
use Keet\Mvc\Traits\EnabledTrait;

/**
 * Setup for ISO3166-1 standard. Includes:
 * - Name
 * - Alpha 2 code
 * - Alpha 3 code
 * - Numeric code
 *
 * Properties linked to Currency and Language entities for related (ISO standardized, if applicable) data.
 *
 * @ORM\Entity(repositoryClass="Keet\Country\Repository\CountryRepository")
 * @ORM\Table(name="country_countries")
 */
class Country extends AbstractEntity
{
    use EnabledTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="alpha2", type="string", length=2, nullable=false, unique=true)
     */
    protected $alpha2;

    /**
     * @var string
     * @ORM\Column(name="alpha3", type="string", length=3, nullable=false, unique=true)
     */
    protected $alpha3;

    /**
     * @var int
     * @ORM\Column(name="`numeric`", type="integer", length=3, nullable=false, unique=true)
     */
    protected $numeric;

    /**
     * @var Currency
     * @ORM\ManyToOne(targetEntity="Keet\Country\Entity\Currency", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    protected $currency;

    /**
     * @var Collection|ArrayCollection|Currency[]
     * @ORM\ManyToMany(targetEntity="Keet\Country\Entity\Currency", inversedBy="countries")
     * @ORM\JoinTable(
     *     name="country_country_currencies",
     *     joinColumns={@ORM\JoinColumn(name="country_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="currency_id", referencedColumnName="id")}
     * )
     */
    protected $currencies;

    /**
     * @var Coordinates
     * @ORM\OneToOne(targetEntity="Keet\Country\Entity\Coordinates", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(name="coordinates_id", referencedColumnName="id")
     */
    protected $coordinates;

    /**
     * @var Collection|ArrayCollection|Timezone[]
     * @ORM\ManyToMany(targetEntity="Keet\Country\Entity\Timezone", inversedBy="countries")
     * @ORM\JoinTable(
     *     name="country_country_timezones",
     *     joinColumns={@ORM\JoinColumn(name="country_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="timezone_id", referencedColumnName="id")}
     * )
     */
    protected $timezones;

    public function __construct()
    {
        $this->timezones = new ArrayCollection();
        $this->currencies = new ArrayCollection();
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
     * @return Country
     */
    public function setName(string $name) : Country
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlpha2() : ?string
    {
        return $this->alpha2;
    }

    /**
     * @param string $alpha2
     *
     * @return Country
     */
    public function setAlpha2(string $alpha2) : Country
    {
        $this->alpha2 = $alpha2;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlpha3() : ?string
    {
        return $this->alpha3;
    }

    /**
     * @param string $alpha3
     *
     * @return Country
     */
    public function setAlpha3(string $alpha3) : Country
    {
        $this->alpha3 = $alpha3;

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
     * @return Country
     */
    public function setNumeric(int $numeric) : Country
    {
        $this->numeric = $numeric;

        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency() : ?Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return Country
     */
    public function setCurrency(Currency $currency): Country
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection|ArrayCollection|Currency[]
     */
    public function getCurrencies() : Collection
    {
        return $this->currencies;
    }

    /**
     * @param Collection|ArrayCollection|Currency[] $currencies
     * @return $this
     */
    public function addCurrencies(Collection $currencies): Country
    {
        foreach ($currencies as $currency) {
            if (!$this->currencies->contains($currency)) {
                $this->currencies->add($currency);
            }

            if (!$currency->getCountries()->contains($this)) {
                $currency->getCountries()->add($this);
            }
        }

        return $this;
    }

    /**
     * @param Collection|ArrayCollection|Currency[] $currencies
     * @return $this
     */
    public function removeCurrencies(Collection $currencies): Country
    {
        foreach ($currencies as $currency) {
            if ($this->currencies->contains($currency)) {
                $this->currencies->removeElement($currency);
            }

            if ($currency->getCountries()->contains($this)) {
                $currency->getCountries()->removeElement($this);
            }
        }

        return $this;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates() : ?Coordinates
    {
        return $this->coordinates;
    }

    /**
     * @param Coordinates $coordinates
     * @return Country
     */
    public function setCoordinates(Coordinates $coordinates): Country
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * @return Collection|ArrayCollection|Timezone[]
     */
    public function getTimezones() : Collection
    {
        return $this->timezones;
    }

    /**
     * @param Collection|ArrayCollection|Timezone[] $timezones
     * @return $this
     */
    public function addTimezones(Collection $timezones): Country
    {
        foreach ($timezones as $timezone) {
            if (!$this->timezones->contains($timezone)) {
                $this->timezones->add($timezone);
            }

            if (!$timezone->getCountries()->contains($this)) {
                $timezone->getCountries()->add($this);
            }
        }

        return $this;
    }

    /**
     * @param Collection|ArrayCollection|Timezone[] $timezones
     * @return $this
     */
    public function removeTimezones(Collection $timezones): Country
    {
        foreach ($timezones as $timezone) {
            if ($this->timezones->contains($timezone)) {
                $this->timezones->removeElement($timezone);
            }

            if ($timezone->getCountries()->contains($this)) {
                $timezone->getCountries()->removeElement($this);
            }
        }

        return $this;
    }

}