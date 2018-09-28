<?php

namespace Keet\Country\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use DomainException;
use Keet\Country\Entity\Currency;
use OutOfBoundsException;

class CurrencyRepository extends EntityRepository
{
    /**
     * @return Collection|ArrayCollection|Currency[]
     */
    public function getEnabledCurrencies() : Collection
    {
        return new ArrayCollection($this->findBy(['enabled' => true], ['name' => 'ASC']));
    }

    /**
     * Lookup ISO4217 data by code identifier.
     *
     * @param string $code
     *
     * @throws DomainException if input does not conform to alpha3 format.
     * @throws OutOfBoundsException if input does not exist in ISO3166-1.
     * @return Currency
     */
    public function getByCode(string $code) : Currency
    {
        if ( ! preg_match('/^[a-zA-Z]{3}$/', $code)) {

            throw new DomainException(sprintf(_('Not a valid alpha3: %s'), $code));
        }

        /** @var Currency $currency */
        $currency = $this->findOneBy(['code' => $code]);

        return $currency;
    }

    /**
     * Lookup ISO4217 data by numeric identifier.
     *
     * @param int $numeric
     *
     * @throws DomainException if input does not conform to numeric format.
     * @throws OutOfBoundsException if input does not exist in ISO3166-1.
     * @return Currency
     */
    public function getByNumber(int $numeric) : Currency
    {
        if ( ! preg_match('/^[0-9]{3}$/', $numeric)) {

            throw new DomainException(sprintf(_('Not a valid numeric: %s'), $numeric));
        }

        /** @var Currency $currency */
        $currency = $this->findOneBy(['numeric' => $numeric]);

        return $currency;
    }
}