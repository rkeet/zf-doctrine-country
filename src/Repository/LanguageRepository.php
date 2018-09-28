<?php

namespace Keet\Country\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use DomainException;
use Keet\Country\Entity\Language;
use OutOfBoundsException;

class LanguageRepository extends EntityRepository
{
    /**
     * @return Collection|ArrayCollection|Language[]
     */
    public function getEnabledLanguages() : Collection
    {
        return new ArrayCollection($this->findBy(['enabled' => true], ['name' => 'ASC']));
    }

    /**
     * Lookup 639-1 data by code identifier.
     *
     * @param string $code
     *
     * @throws DomainException if input does not conform to code format.
     * @throws OutOfBoundsException if input does not exist in 639-1.
     * @return Language
     */
    public function getByCode(string $code) : Language
    {
        if ( ! preg_match('/^[a-zA-Z]{2,10}$/', $code)) { // Codes are a minimum of 2 and maximum of 10 chars long

            throw new DomainException(sprintf(_('Not a valid language code: %s'), $code));
        }

        /** @var Language $language */
        $language = $this->findOneBy(['code' => $code]);

        return $language;
    }
}