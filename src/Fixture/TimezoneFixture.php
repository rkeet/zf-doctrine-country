<?php

namespace Keet\Country\Fixture;

use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\Entity\Country;
use Keet\Country\Entity\Timezone;
use Keet\Country\Repository\CountryRepository;

/**
 * Pre-loads all Timezones entities
 *
 * Class TimezoneFixture
 *
 * @package Keet\Country\Fixture
 */
class TimezoneFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var CountryRepository $countryRepo */
        $countryRepo = $manager->getRepository(Country::class);

        foreach (DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $phpTimezone) {
            $zone = new \DateTimeZone($phpTimezone);

            $timezone = new Timezone();
            $timezone->setName($zone->getName());

            // Get abbreviation
            $timezone->setAbbreviation(
                (new \DateTime('now'))->setTimezone($zone)->format('T')
            );

            // Link Timezone and Country objects
            $country = $countryRepo->findOneBy(['alpha2' => $zone->getLocation()['country_code']]);
            if ($country instanceof Country) {
                $country->addTimezones(new ArrayCollection([$timezone]));
                $manager->persist($country);

                $timezone->addCountries(new ArrayCollection([$country]));
            }

            $manager->persist($timezone);
        }

        $manager->flush();
    }

    /**
     * Returns Fixture classes this one depends upon to be run first.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CountryFixture::class,
        ];
    }
}
