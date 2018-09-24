<?php

namespace Keet\Country\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\Entity\Currency;

/**
 * Pre-loads all Currency entities
 *
 * Class CurrencyFixture
 *
 * @package Keet\Country\Fixture
 */
class CurrencyFixture extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'data_src'
            . DIRECTORY_SEPARATOR . 'databases'
            . DIRECTORY_SEPARATOR . 'iso4217.json';

        if (file_exists($filename)) {
            $json = json_decode(file_get_contents($filename), true);

            foreach ($json as $key => $value) {
                $currency = new Currency();
                $currency
                    ->setCode($value['code'])
                    ->setName($value['name'])
                    ->setDecimals($value['digits'])
                    ->setNumeric($value['numeric'])
                    ->setEnabled($value['enabled']);

                $manager->persist($currency);
            }

            $manager->flush();
        }
    }
}