<?php

namespace Keet\Country\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Keet\Mvc\Entity\AbstractEntity;

/**
 * NOTE: Stores just Timezone names and links them to Country Entities. To use them to display time, make sure
 * to use a DateTime and set its timezone by creating a new DateTimeZone object, using this Timezone object, and set
 * that as the timezone for the DateTime object.
 *
 * This Entity is purely to allow for selectors for timezones to be present in the application.
 *
 * @ORM\Entity
 * @ORM\Table(name="country_timezones")
 */
class Timezone extends AbstractEntity
{
    /**
     * @var Collection|ArrayCollection|Country[]
     * @ORM\ManyToMany(targetEntity="Keet\Country\Entity\Country", mappedBy="timezones")
     */
    protected $countries;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="abbreviation", type="string", length=10, nullable=false)
     */
    protected $abbreviation;

    public function __construct()
    {
        $this->countries = new ArrayCollection();
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
    public function addCountries(Collection $countries): Timezone
    {
        foreach ($countries as $country) {
            if (!$this->countries->contains($country)) {
                $this->countries->add($country);
            }

            if (!$country->getTimezones()->contains($this)) {
                $country->getTimezones()->add($this);
            }
        }

        return $this;
    }

    /**
     * @param Collection|ArrayCollection|Country[] $countries
     * @return $this
     */
    public function removeCountries(Collection $countries): Timezone
    {
        foreach ($countries as $country) {
            if ($this->countries->contains($country)) {
                $this->countries->removeElement($country);
            }

            if ($country->getTimezones()->contains($this)) {
                $country->getTimezones()->removeElement($this);
            }
        }

        return $this;
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
     * @return Timezone
     */
    public function setName(string $name) : Timezone
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbbreviation() : ?string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     *
     * @return Timezone
     */
    public function setAbbreviation(string $abbreviation) : Timezone
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

}