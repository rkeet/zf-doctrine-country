<?php

namespace Keet\Country\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use DomainException;
use Keet\Country\Entity\Country;
use OutOfBoundsException;

class CountryRepository extends EntityRepository
{
    /**
     * @return Collection|ArrayCollection|Country[]
     */
    public function getEnabledCountries() : Collection
    {
        return new ArrayCollection($this->findBy(['enabled' => true], ['name' => 'ASC']));
    }

    /**
     * Lookup ISO3166-1 data by alpha2 identifier.
     *
     * @param string $alpha2
     *
     * @throws DomainException if input does not conform to alpha2 format.
     * @throws OutOfBoundsException if input does not exist in ISO3166-1.
     * @return Country|boolean
     */
    public function getByAlpha2(string $alpha2) : Country
    {
        if ( ! preg_match('/^[a-zA-Z]{2}$/', $alpha2)) {

            throw new DomainException(sprintf(_('Not a valid alpha2: %s'), $alpha2));
        }

        /** @var Country $country */
        $country = $this->findOneBy(['alpha2' => $alpha2]);

        return $country;
    }

    /**
     * Lookup ISO3166-1 data by alpha3 identifier.
     *
     * @param string $alpha3
     *
     * @throws DomainException if input does not conform to alpha3 format.
     * @throws OutOfBoundsException if input does not exist in ISO3166-1.
     * @return Country
     */
    public function getByAlpha3(string $alpha3) : Country
    {
        if ( ! preg_match('/^[a-zA-Z]{3}$/', $alpha3)) {

            throw new DomainException(sprintf(_('Not a valid alpha3: %s'), $alpha3));
        }

        /** @var Country $country */
        $country = $this->findOneBy(['alpha3' => $alpha3]);

        return $country;
    }

    /**
     * Lookup ISO3166-1 data by numeric identifier (numerical string, that is).
     *
     * @param int $numeric
     *
     * @throws DomainException if input does not conform to numeric format.
     * @throws OutOfBoundsException if input does not exist in ISO3166-1.
     * @return Country
     */
    public function getByNumber(int $numeric) : Country
    {
        if ( ! preg_match('/^[0-9]{3}$/', $numeric)) {

            throw new DomainException(sprintf(_('Not a valid numeric: %s'), $numeric));
        }

        /** @var Country $country */
        $country = $this->findOneBy(['numeric' => $numeric]);

        return $country;
    }
}