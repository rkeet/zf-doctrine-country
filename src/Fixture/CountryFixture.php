<?php

namespace Keet\Country\Fixture;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\Entity\Coordinates;
use Keet\Country\Entity\Country;
use Keet\Country\Entity\Currency;
use Keet\Country\Repository\CurrencyRepository;

/**
 * Pre-loads all Country entities
 *
 * Class CountryFixture
 *
 * @package Keet\Country\Fixture
 */
class CountryFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var CurrencyRepository
     */
    protected $currencyRepo;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /** @var CurrencyRepository $currencyRepo */
        $currencyRepo = $manager->getRepository(Currency::class);
        $this->setCurrencyRepo($currencyRepo);

        if (count($this->countries) > 0) {
            foreach ($this->countries as $key => $value) {
                $country = new Country();
                $country
                    ->setName($value['name'])
                    ->setAlpha2($value['alpha2'])
                    ->setAlpha3($value['alpha3'])
                    ->setNumeric($value['numeric'])
                    ->setEnabled($value['enabled']);

                if (isset($value['currency'])) {
                    if (is_array($value['currency'])) {
                        // Loop and add all currencies
                        foreach ($value['currency'] as $currencyCode) {
                            $currency = $this->getCountryCurrency($currencyCode);
                            if ($currency instanceof Currency) {

                                $country->addCurrencies(new ArrayCollection([$currency]));
                            }
                        }

                        // Add the primary currency as "the" currency
                        if (isset($value['primary_currency'])) {
                            $currency = $this->getCountryCurrency($value['primary_currency']);
                            if ($currency instanceof Currency) {

                                $country->setCurrency($currency);
                            }
                        }
                    } else {
                        $currency = $this->getCountryCurrency($value['currency']);
                        if ($currency instanceof Currency) {

                            $country->setCurrency($currency);
                            $country->addCurrencies(new ArrayCollection([$currency]));
                        }
                    }
                }

                if (isset($value['coordinates']) && is_array($value['coordinates'])) {
                    $coordinates = $value['coordinates'];

                    if (isset($coordinates['latitude']) && isset($coordinates['longitude'])) {
                        $coords = new Coordinates();
                        $coords
                            ->setLatitude($coordinates['latitude'])
                            ->setLongitude($coordinates['longitude']);

                        $manager->persist($coords);

                        $country->setCoordinates($coords);
                    }
                }

                $manager->persist($country);
            }

            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CurrencyFixture::class,
        ];
    }

    /**
     * @param $code
     *
     * @return bool|Currency
     */
    public function getCountryCurrency($code)
    {
        $currency = $this->getCurrencyRepo()->findOneBy(['code' => $code]);

        if ($currency instanceof Currency) {

            return $currency;
        }

        return false;
    }

    /**
     * @return CurrencyRepository
     */
    public function getCurrencyRepo()
    {
        return $this->currencyRepo;
    }

    /**
     * @param CurrencyRepository $currencyRepo
     *
     * @return CountryFixture
     */
    public function setCurrencyRepo($currencyRepo)
    {
        $this->currencyRepo = $currencyRepo;

        return $this;
    }

    protected $countries = [
        [
            'name'        => 'Afghanistan',
            'alpha2'      => 'AF',
            'alpha3'      => 'AFG',
            'numeric'     => '004',
            'currency'    => 'AFN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '33.6062068',
                'longitude' => '58.7053709',
            ],
        ],
        [
            'name'        => 'Åland Islands',
            'alpha2'      => 'AX',
            'alpha3'      => 'ALA',
            'numeric'     => '248',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '60.1948871',
                'longitude' => '19.2423547',
            ],
        ],
        [
            'name'        => 'Albania',
            'alpha2'      => 'AL',
            'alpha3'      => 'ALB',
            'numeric'     => '008',
            'currency'    => 'ALL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '41.1474716',
                'longitude' => '19.039574',
            ],
        ],
        [
            'name'        => 'Algeria',
            'alpha2'      => 'DZ',
            'alpha3'      => 'DZA',
            'numeric'     => '012',
            'currency'    => 'DZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '26.830675',
                'longitude' => '-16.5050268',
            ],
        ],
        [
            'name'        => 'American Samoa',
            'alpha2'      => 'AS',
            'alpha3'      => 'ASM',
            'numeric'     => '016',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-14.3015987',
                'longitude' => '-170.8362659',
            ],
        ],
        [
            'name'        => 'Andorra',
            'alpha2'      => 'AD',
            'alpha3'      => 'AND',
            'numeric'     => '020',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '42.5419286',
                'longitude' => '1.3174949',
            ],
        ],
        [
            'name'        => 'Angola',
            'alpha2'      => 'AO',
            'alpha3'      => 'AGO',
            'numeric'     => '024',
            'currency'    => 'AOA',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-11.0778749',
                'longitude' => '8.8443708',
            ],
        ],
        [
            'name'        => 'Anguilla',
            'alpha2'      => 'AI',
            'alpha3'      => 'AIA',
            'numeric'     => '660',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.223926',
                'longitude' => '-63.199052',
            ],
        ],
        [
            'name'        => 'Antarctica',
            'alpha2'      => 'AQ',
            'alpha3'      => 'ATA',
            'numeric'     => '010',
            'currency'    => 'NOK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-2.8787624',
                'longitude' => '-89.2308936',
            ],
        ],
        [
            'name'        => 'Antigua and Barbuda',
            'alpha2'      => 'AG',
            'alpha3'      => 'ATG',
            'numeric'     => '028',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '17.0868877',
                'longitude' => '-61.9235344',
            ],
        ],
        [
            'name'        => 'Argentina',
            'alpha2'      => 'AR',
            'alpha3'      => 'ARG',
            'numeric'     => '032',
            'currency'    => 'ARS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-37.0271746',
                'longitude' => '-81.6050871',
            ],
        ],
        [
            'name'        => 'Armenia',
            'alpha2'      => 'AM',
            'alpha3'      => 'ARM',
            'numeric'     => '051',
            'currency'    => 'AMD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '40.0489899',
                'longitude' => '42.79792',
            ],
        ],
        [
            'name'        => 'Aruba',
            'alpha2'      => 'AW',
            'alpha3'      => 'ABW',
            'numeric'     => '533',
            'currency'    => 'AWG',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.5175309',
                'longitude' => '-70.1049815',
            ],
        ],
        [
            'name'        => 'Australia',
            'alpha2'      => 'AU',
            'alpha3'      => 'AUS',
            'numeric'     => '036',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-21.2331662',
                'longitude' => '95.6409911',
            ],
        ],
        [
            'name'        => 'Austria',
            'alpha2'      => 'AT',
            'alpha3'      => 'AUT',
            'numeric'     => '040',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '47.6089598',
                'longitude' => '8.8600834',
            ],
        ],
        [
            'name'        => 'Azerbaijan',
            'alpha2'      => 'AZ',
            'alpha3'      => 'AZE',
            'numeric'     => '031',
            'currency'    => 'AZN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '40.0655697',
                'longitude' => '43.2038931',
            ],
        ],
        [
            'name'        => 'Bahamas',
            'alpha2'      => 'BS',
            'alpha3'      => 'BHS',
            'numeric'     => '044',
            'currency'    => 'BSD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '24.1672597',
                'longitude' => '-84.983462',
            ],
        ],
        [
            'name'        => 'Bahrain',
            'alpha2'      => 'BH',
            'alpha3'      => 'BHR',
            'numeric'     => '048',
            'currency'    => 'BHD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '25.9548472',
                'longitude' => '50.3213146',
            ],
        ],
        [
            'name'        => 'Bangladesh',
            'alpha2'      => 'BD',
            'alpha3'      => 'BGD',
            'numeric'     => '050',
            'currency'    => 'BDT',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '23.6738549',
                'longitude' => '88.100764',
            ],
        ],
        [
            'name'        => 'Barbados',
            'alpha2'      => 'BB',
            'alpha3'      => 'BRB',
            'numeric'     => '052',
            'currency'    => 'BBD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.189993',
                'longitude' => '-59.6755572',
            ],
        ],
        [
            'name'        => 'Belarus',
            'alpha2'      => 'BY',
            'alpha3'      => 'BLR',
            'numeric'     => '112',
            'currency'    => 'BYR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '53.6331364',
                'longitude' => '23.4940851',
            ],
        ],
        [
            'name'        => 'Belgium',
            'alpha2'      => 'BE',
            'alpha3'      => 'BEL',
            'numeric'     => '056',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '50.4795384',
                'longitude' => '2.2345299',
            ],
        ],
        [
            'name'        => 'Belize',
            'alpha2'      => 'BZ',
            'alpha3'      => 'BLZ',
            'numeric'     => '084',
            'currency'    => 'BZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '17.187683',
                'longitude' => '-89.4808612',
            ],
        ],
        [
            'name'        => 'Benin',
            'alpha2'      => 'BJ',
            'alpha3'      => 'BEN',
            'numeric'     => '204',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '9.3145809',
                'longitude' => '0.0659279',
            ],
        ],
        [
            'name'        => 'Bermuda',
            'alpha2'      => 'BM',
            'alpha3'      => 'BMU',
            'numeric'     => '060',
            'currency'    => 'BMD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '32.3189423',
                'longitude' => '-64.9075103',
            ],
        ],
        [
            'name'        => 'Bhutan',
            'alpha2'      => 'BT',
            'alpha3'      => 'BTN',
            'numeric'     => '064',
            'currency'    => 'BTN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '27.5134168',
                'longitude' => '88.1924084',
            ],
        ],
        [
            'name'        => 'Bolivia (Plurinational State of)',
            'alpha2'      => 'BO',
            'alpha3'      => 'BOL',
            'numeric'     => '068',
            'currency'    => 'BOB',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-16.092442',
                'longitude' => '-72.5783538',
            ],
        ],
        [
            'name'        => 'Bonaire, Sint Eustatius and Saba',
            'alpha2'      => 'BQ',
            'alpha3'      => 'BES',
            'numeric'     => '535',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.1684873',
                'longitude' => '-68.4481499',
            ],
        ],
        [
            'name'        => 'Bosnia and Herzegovina',
            'alpha2'      => 'BA',
            'alpha3'      => 'BIH',
            'numeric'     => '070',
            'currency'    => 'BAM',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '43.894605',
                'longitude' => '15.4295472',
            ],
        ],
        [
            'name'        => 'Botswana',
            'alpha2'      => 'BW',
            'alpha3'      => 'BWA',
            'numeric'     => '072',
            'currency'    => 'BWP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-22.2808897',
                'longitude' => '20.1935853',
            ],
        ],
        [
            'name'        => 'Bouvet Island',
            'alpha2'      => 'BV',
            'alpha3'      => 'BVT',
            'numeric'     => '074',
            'currency'    => 'NOK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-54.4204948',
                'longitude' => '3.2895414',
            ],
        ],
        [
            'name'        => 'Brazil',
            'alpha2'      => 'BR',
            'alpha3'      => 'BRA',
            'numeric'     => '076',
            'currency'    => 'BRL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-11.1532339',
                'longitude' => '-90.4346252',
            ],
        ],
        [
            'name'        => 'British Indian Ocean Territory',
            'alpha2'      => 'IO',
            'alpha3'      => 'IOT',
            'numeric'     => '086',
            'currency'    => 'GBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-7.3346178',
                'longitude' => '72.3542107',
            ],
        ],
        [
            'name'             => 'Brunei Darussalam',
            'alpha2'           => 'BN',
            'alpha3'           => 'BRN',
            'numeric'          => '096',
            'currency'         => [
                'BND',
                'SGD',
            ],
            'enabled'          => false,
            'primary_currency' => 'BND',
            'coordinates'      => [
                'latitude'  => '4.523386',
                'longitude' => '113.5983816',
            ],
        ],
        [
            'name'        => 'Bulgaria',
            'alpha2'      => 'BG',
            'alpha3'      => 'BGR',
            'numeric'     => '100',
            'currency'    => 'BGN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '42.6376745',
                'longitude' => '20.9958952',
            ],
        ],
        [
            'name'        => 'Burkina Faso',
            'alpha2'      => 'BF',
            'alpha3'      => 'BFA',
            'numeric'     => '854',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.210713',
                'longitude' => '-6.0510594',
            ],
        ],
        [
            'name'        => 'Burundi',
            'alpha2'      => 'BI',
            'alpha3'      => 'BDI',
            'numeric'     => '108',
            'currency'    => 'BIF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-3.38888',
                'longitude' => '28.8040225',
            ],
        ],
        [
            'name'        => 'Cambodia',
            'alpha2'      => 'KH',
            'alpha3'      => 'KHM',
            'numeric'     => '116',
            'currency'    => 'KHR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.2652143',
                'longitude' => '100.4852424',
            ],
        ],
        [
            'name'        => 'Cameroon',
            'alpha2'      => 'CM',
            'alpha3'      => 'CMR',
            'numeric'     => '120',
            'currency'    => 'XAF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '7.3472231',
                'longitude' => '7.8486769',
            ],
        ],
        [
            'name'        => 'Canada',
            'alpha2'      => 'CA',
            'alpha3'      => 'CAN',
            'numeric'     => '124',
            'currency'    => 'CAD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '14.0335239',
                'longitude' => '-157.3762799',
            ],
        ],
        [
            'name'        => 'Cabo Verde',
            'alpha2'      => 'CV',
            'alpha3'      => 'CPV',
            'numeric'     => '132',
            'currency'    => 'CVE',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.1199695',
                'longitude' => '-23.8853735',
            ],
        ],
        [
            'name'        => 'Cayman Islands',
            'alpha2'      => 'KY',
            'alpha3'      => 'CYM',
            'numeric'     => '136',
            'currency'    => 'KYD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '19.3296622',
                'longitude' => '-81.5326153',
            ],
        ],
        [
            'name'        => 'Central African Republic',
            'alpha2'      => 'CF',
            'alpha3'      => 'CAF',
            'numeric'     => '140',
            'currency'    => 'XAF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '6.5379425',
                'longitude' => '11.8991171',
            ],
        ],
        [
            'name'        => 'Chad',
            'alpha2'      => 'TD',
            'alpha3'      => 'TCD',
            'numeric'     => '148',
            'currency'    => 'XAF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.2636491',
                'longitude' => '9.7050139',
            ],
        ],
        [
            'name'        => 'Chile',
            'alpha2'      => 'CL',
            'alpha3'      => 'CHL',
            'numeric'     => '152',
            'currency'    => 'CLP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-35.3661741',
                'longitude' => '-89.0907238',
            ],
        ],
        [
            'name'        => 'China',
            'alpha2'      => 'CN',
            'alpha3'      => 'CHN',
            'numeric'     => '156',
            'currency'    => 'CNY',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '30.151573',
                'longitude' => '67.6131165',
            ],
        ],
        [
            'name'        => 'Christmas Island',
            'alpha2'      => 'CX',
            'alpha3'      => 'CXR',
            'numeric'     => '162',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-10.4913374',
                'longitude' => '105.4829427',
            ],
        ],
        [
            'name'        => 'Cocos (Keeling) Islands',
            'alpha2'      => 'CC',
            'alpha3'      => 'CCK',
            'numeric'     => '166',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-12.1706897',
                'longitude' => '96.8067283',
            ],
        ],
        [
            'name'        => 'Colombia',
            'alpha2'      => 'CO',
            'alpha3'      => 'COL',
            'numeric'     => '170',
            'currency'    => 'COP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '4.0647179',
                'longitude' => '-81.9690201',
            ],
        ],
        [
            'name'        => 'Comoros',
            'alpha2'      => 'KM',
            'alpha3'      => 'COM',
            'numeric'     => '174',
            'currency'    => 'KMF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-11.6517829',
                'longitude' => '43.2331633',
            ],
        ],
        [
            'name'        => 'Congo',
            'alpha2'      => 'CG',
            'alpha3'      => 'COG',
            'numeric'     => '178',
            'currency'    => 'XAF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-0.6585577',
                'longitude' => '10.4020966',
            ],
        ],
        [
            'name'        => 'Congo (Democratic Republic of the)',
            'alpha2'      => 'CD',
            'alpha3'      => 'COD',
            'numeric'     => '180',
            'currency'    => 'CDF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-3.9835921',
                'longitude' => '12.6913223',
            ],
        ],
        [
            'name'        => 'Cook Islands',
            'alpha2'      => 'CK',
            'alpha3'      => 'COK',
            'numeric'     => '184',
            'currency'    => 'NZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-21.2357083',
                'longitude' => '-159.8474038',
            ],
        ],
        [
            'name'        => 'Costa Rica',
            'alpha2'      => 'CR',
            'alpha3'      => 'CRI',
            'numeric'     => '188',
            'currency'    => 'CRC',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '9.6229424',
                'longitude' => '-86.4981756',
            ],
        ],
        [
            'name'        => 'Côte d\'Ivoire',
            'alpha2'      => 'CI',
            'alpha3'      => 'CIV',
            'numeric'     => '384',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '7.5277907',
                'longitude' => '-10.0434388',
            ],
        ],
        [
            'name'        => 'Croatia',
            'alpha2'      => 'HR',
            'alpha3'      => 'HRV',
            'numeric'     => '191',
            'currency'    => 'HRK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '44.3834493',
                'longitude' => '11.9820792',
            ],
        ],
        [
            'name'             => 'Cuba',
            'alpha2'           => 'CU',
            'alpha3'           => 'CUB',
            'numeric'          => '192',
            'currency'         => [
                'CUP',
                'CUC',
            ],
            'enabled'          => false,
            'primary_currency' => 'CUP',
            'coordinates'      => [
                'latitude'  => '21.3087654',
                'longitude' => '-88.5635893',
            ],
        ],
        [
            'name'        => 'Curaçao',
            'alpha2'      => 'CW',
            'alpha3'      => 'CUW',
            'numeric'     => '531',
            'currency'    => 'ANG',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.2133993',
                'longitude' => '-69.2298677',
            ],
        ],
        [
            'name'        => 'Cyprus',
            'alpha2'      => 'CY',
            'alpha3'      => 'CYP',
            'numeric'     => '196',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '35.1645854',
                'longitude' => '32.3159096',
            ],
        ],
        [
            'name'        => 'Czech Republic',
            'alpha2'      => 'CZ',
            'alpha3'      => 'CZE',
            'numeric'     => '203',
            'currency'    => 'CZK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '49.7170986',
                'longitude' => '10.9900159',
            ],
        ],
        [
            'name'        => 'Denmark',
            'alpha2'      => 'DK',
            'alpha3'      => 'DNK',
            'numeric'     => '208',
            'currency'    => 'DKK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '56.1351947',
                'longitude' => '8.191094',
            ],
        ],
        [
            'name'        => 'Djibouti',
            'alpha2'      => 'DJ',
            'alpha3'      => 'DJI',
            'numeric'     => '262',
            'currency'    => 'DJF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '11.8205801',
                'longitude' => '41.4673135',
            ],
        ],
        [
            'name'        => 'Dominica',
            'alpha2'      => 'DM',
            'alpha3'      => 'DMA',
            'numeric'     => '212',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.4236904',
                'longitude' => '-61.5000878',
            ],
        ],
        [
            'name'        => 'Dominican Republic',
            'alpha2'      => 'DO',
            'alpha3'      => 'DOM',
            'numeric'     => '214',
            'currency'    => 'DOP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.6876645',
                'longitude' => '-72.4089927',
            ],
        ],
        [
            'name'        => 'Ecuador',
            'alpha2'      => 'EC',
            'alpha3'      => 'ECU',
            'numeric'     => '218',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-1.7874177',
                'longitude' => '-82.6330826',
            ],
        ],
        [
            'name'        => 'Egypt',
            'alpha2'      => 'EG',
            'alpha3'      => 'EGY',
            'numeric'     => '818',
            'currency'    => 'EGP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '26.5498468',
                'longitude' => '21.7832462',
            ],
        ],
        [
            'name'        => 'El Salvador',
            'alpha2'      => 'SV',
            'alpha3'      => 'SLV',
            'numeric'     => '222',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.8004522',
                'longitude' => '-90.0265497',
            ],
        ],
        [
            'name'        => 'Equatorial Guinea',
            'alpha2'      => 'GQ',
            'alpha3'      => 'GNQ',
            'numeric'     => '226',
            'currency'    => 'XAF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '1.619254',
                'longitude' => '9.1965343',
            ],
        ],
        [
            'name'        => 'Eritrea',
            'alpha2'      => 'ER',
            'alpha3'      => 'ERI',
            'numeric'     => '232',
            'currency'    => 'ERN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.1430035',
                'longitude' => '35.2931964',
            ],
        ],
        [
            'name'        => 'Estonia',
            'alpha2'      => 'EE',
            'alpha3'      => 'EST',
            'numeric'     => '233',
            'currency'    => 'EEK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '58.5267316',
                'longitude' => '20.5049056',
            ],
        ],
        [
            'name'        => 'Ethiopia',
            'alpha2'      => 'ET',
            'alpha3'      => 'ETH',
            'numeric'     => '231',
            'currency'    => 'ETB',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '9.0375182',
                'longitude' => '31.4633906',
            ],
        ],
        [
            'name'        => 'Falkland Islands (Malvinas)',
            'alpha2'      => 'FK',
            'alpha3'      => 'FLK',
            'numeric'     => '238',
            'currency'    => 'FKP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-51.7093203',
                'longitude' => '-61.759642',
            ],
        ],
        [
            'name'        => 'Faroe Islands',
            'alpha2'      => 'FO',
            'alpha3'      => 'FRO',
            'numeric'     => '234',
            'currency'    => 'DKK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '61.8880338',
                'longitude' => '-8.0937493',
            ],
        ],
        [
            'name'        => 'Fiji',
            'alpha2'      => 'FJ',
            'alpha3'      => 'FJI',
            'numeric'     => '242',
            'currency'    => 'FJD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-17.4499133',
                'longitude' => '177.0144669',
            ],
        ],
        [
            'name'        => 'Finland',
            'alpha2'      => 'FI',
            'alpha3'      => 'FIN',
            'numeric'     => '246',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '64.6477914',
                'longitude' => '17.1420145',
            ],
        ],
        [
            'name'        => 'France',
            'alpha2'      => 'FR',
            'alpha3'      => 'FRA',
            'numeric'     => '250',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '45.8637016',
                'longitude' => '-6.7610134',
            ],
        ],
        [
            'name'        => 'French Guiana',
            'alpha2'      => 'GF',
            'alpha3'      => 'GUF',
            'numeric'     => '254',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '3.9277447',
                'longitude' => '-55.3316325',
            ],
        ],
        [
            'name'        => 'French Polynesia',
            'alpha2'      => 'PF',
            'alpha3'      => 'PYF',
            'numeric'     => '258',
            'currency'    => 'XPF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-17.6865798',
                'longitude' => '-149.6530109',
            ],
        ],
        [
            'name'        => 'French Southern Territories',
            'alpha2'      => 'TF',
            'alpha3'      => 'ATF',
            'numeric'     => '260',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-49.1252506',
                'longitude' => '68.4579934',
            ],
        ],
        [
            'name'        => 'Gabon',
            'alpha2'      => 'GA',
            'alpha3'      => 'GAB',
            'numeric'     => '266',
            'currency'    => 'XAF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-0.818821',
                'longitude' => '7.1167509',
            ],
        ],
        [
            'name'        => 'Gambia',
            'alpha2'      => 'GM',
            'alpha3'      => 'GMB',
            'numeric'     => '270',
            'currency'    => 'GMD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.421532',
                'longitude' => '-17.5471681',
            ],
        ],
        [
            'name'        => 'Georgia',
            'alpha2'      => 'GE',
            'alpha3'      => 'GEO',
            'numeric'     => '268',
            'currency'    => 'GEL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '42.2332226',
                'longitude' => '38.883812',
            ],
        ],
        [
            'name'        => 'Germany',
            'alpha2'      => 'DE',
            'alpha3'      => 'DEU',
            'numeric'     => '276',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '51.0783476',
                'longitude' => '5.9697595',
            ],
        ],
        [
            'name'        => 'Ghana',
            'alpha2'      => 'GH',
            'alpha3'      => 'GHA',
            'numeric'     => '288',
            'currency'    => 'GHS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '7.9509285',
                'longitude' => '-3.2746726',
            ],
        ],
        [
            'name'        => 'Gibraltar',
            'alpha2'      => 'GI',
            'alpha3'      => 'GIB',
            'numeric'     => '292',
            'currency'    => 'GIP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '36.1319755',
                'longitude' => '-5.370427',
            ],
        ],
        [
            'name'        => 'Greece',
            'alpha2'      => 'GR',
            'alpha3'      => 'GRC',
            'numeric'     => '300',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '38.1898207',
                'longitude' => '19.3208252',
            ],
        ],
        [
            'name'        => 'Greenland',
            'alpha2'      => 'GL',
            'alpha3'      => 'GRL',
            'numeric'     => '304',
            'currency'    => 'DKK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '68.5555356',
                'longitude' => '-74.8646438',
            ],
        ],
        [
            'name'        => 'Grenada',
            'alpha2'      => 'GD',
            'alpha3'      => 'GRD',
            'numeric'     => '308',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.1099334',
                'longitude' => '-61.8336349',
            ],
        ],
        [
            'name'        => 'Guadeloupe',
            'alpha2'      => 'GP',
            'alpha3'      => 'GLP',
            'numeric'     => '312',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '16.1724199',
                'longitude' => '-61.966313',
            ],
        ],
        [
            'name'        => 'Guam',
            'alpha2'      => 'GU',
            'alpha3'      => 'GUM',
            'numeric'     => '316',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.4440512',
                'longitude' => '144.5073432',
            ],
        ],
        [
            'name'        => 'Guatemala',
            'alpha2'      => 'GT',
            'alpha3'      => 'GTM',
            'numeric'     => '320',
            'currency'    => 'GTQ',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.7663703',
                'longitude' => '-92.4751385',
            ],
        ],
        [
            'name'        => 'Guernsey',
            'alpha2'      => 'GG',
            'alpha3'      => 'GGY',
            'numeric'     => '831',
            'currency'    => 'GBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '49.4629808',
                'longitude' => '-2.7281937',
            ],
        ],
        [
            'name'        => 'Guinea',
            'alpha2'      => 'GN',
            'alpha3'      => 'GIN',
            'numeric'     => '324',
            'currency'    => 'GNF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '9.9027551',
                'longitude' => '-15.8524913',
            ],
        ],
        [
            'name'        => 'Guinea-Bissau',
            'alpha2'      => 'GW',
            'alpha3'      => 'GNB',
            'numeric'     => '624',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '11.7669162',
                'longitude' => '-17.4147772',
            ],
        ],
        [
            'name'        => 'Guyana',
            'alpha2'      => 'GY',
            'alpha3'      => 'GUY',
            'numeric'     => '328',
            'currency'    => 'GYD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '4.8519699',
                'longitude' => '-61.1970637',
            ],
        ],
        [
            'name'        => 'Haiti',
            'alpha2'      => 'HT',
            'alpha3'      => 'HTI',
            'numeric'     => '332',
            'currency'    => 'HTG',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '19.0421524',
                'longitude' => '-75.2950154',
            ],
        ],
        [
            'name'        => 'Heard Island and McDonald Islands',
            'alpha2'      => 'HM',
            'alpha3'      => 'HMD',
            'numeric'     => '334',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-53.0763771',
                'longitude' => '73.23349',
            ],
        ],
        [
            'name'        => 'Holy See (Vatican)',
            'alpha2'      => 'VA',
            'alpha3'      => 'VAT',
            'numeric'     => '336',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '41.903816',
                'longitude' => '12.4433064',
            ],
        ],
        [
            'name'        => 'Honduras',
            'alpha2'      => 'HN',
            'alpha3'      => 'HND',
            'numeric'     => '340',
            'currency'    => 'HNL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '14.7071374',
                'longitude' => '-90.7370417',
            ],
        ],
        [
            'name'        => 'Hong Kong',
            'alpha2'      => 'HK',
            'alpha3'      => 'HKG',
            'numeric'     => '344',
            'currency'    => 'HKD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '22.3574372',
                'longitude' => '113.8408282',
            ],
        ],
        [
            'name'        => 'Hungary',
            'alpha2'      => 'HU',
            'alpha3'      => 'HUN',
            'numeric'     => '348',
            'currency'    => 'HUF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '47.0735094',
                'longitude' => '15.0198722',
            ],
        ],
        [
            'name'        => 'Iceland',
            'alpha2'      => 'IS',
            'alpha3'      => 'ISL',
            'numeric'     => '352',
            'currency'    => 'ISK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '64.6622172',
                'longitude' => '-27.941755',
            ],
        ],
        [
            'name'        => 'India',
            'alpha2'      => 'IN',
            'alpha3'      => 'IND',
            'numeric'     => '356',
            'currency'    => 'INR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '20.1543012',
                'longitude' => '64.5157466',
            ],
        ],
        [
            'name'        => 'Indonesia',
            'alpha2'      => 'ID',
            'alpha3'      => 'IDN',
            'numeric'     => '360',
            'currency'    => 'IDR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-1.9650669',
                'longitude' => '78.4055884',
            ],
        ],
        [
            'name'        => 'Iran (Islamic Republic of)',
            'alpha2'      => 'IR',
            'alpha3'      => 'IRN',
            'numeric'     => '364',
            'currency'    => 'IRR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '32.1000194',
                'longitude' => '44.681751',
            ],
        ],
        [
            'name'        => 'Iraq',
            'alpha2'      => 'IQ',
            'alpha3'      => 'IRQ',
            'numeric'     => '368',
            'currency'    => 'IQD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '33.1402399',
                'longitude' => '39.2237971',
            ],
        ],
        [
            'name'        => 'Ireland',
            'alpha2'      => 'IE',
            'alpha3'      => 'IRL',
            'numeric'     => '372',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '53.3313199',
                'longitude' => '-12.4395195',
            ],
        ],
        [
            'name'        => 'Isle of Man',
            'alpha2'      => 'IM',
            'alpha3'      => 'IMN',
            'numeric'     => '833',
            'currency'    => 'GBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '54.2309467',
                'longitude' => '-4.8496752',
            ],
        ],
        [
            'name'        => 'Israel',
            'alpha2'      => 'IL',
            'alpha3'      => 'ISR',
            'numeric'     => '376',
            'currency'    => 'ILS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '31.4068469',
                'longitude' => '33.9607096',
            ],
        ],
        [
            'name'        => 'Italy',
            'alpha2'      => 'IT',
            'alpha3'      => 'ITA',
            'numeric'     => '380',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '40.9423364',
                'longitude' => '3.5921831',
            ],
        ],
        [
            'name'        => 'Jamaica',
            'alpha2'      => 'JM',
            'alpha3'      => 'JAM',
            'numeric'     => '388',
            'currency'    => 'JMD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.1122755',
                'longitude' => '-78.3972015',
            ],
        ],
        [
            'name'        => 'Japan',
            'alpha2'      => 'JP',
            'alpha3'      => 'JPN',
            'numeric'     => '392',
            'currency'    => 'JPY',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '33.4389529',
                'longitude' => '116.3085524',
            ],
        ],
        [
            'name'        => 'Jersey',
            'alpha2'      => 'JE',
            'alpha3'      => 'JEY',
            'numeric'     => '832',
            'currency'    => 'GBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '49.2110419',
                'longitude' => '-2.2727143',
            ],
        ],
        [
            'name'        => 'Jordan',
            'alpha2'      => 'JO',
            'alpha3'      => 'JOR',
            'numeric'     => '400',
            'currency'    => 'JOD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '31.2603733',
                'longitude' => '34.8793524',
            ],
        ],
        [
            'name'        => 'Kazakhstan',
            'alpha2'      => 'KZ',
            'alpha3'      => 'KAZ',
            'numeric'     => '398',
            'currency'    => 'KZT',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '42.3159165',
                'longitude' => '31.9502965',
            ],
        ],
        [
            'name'        => 'Kenya',
            'alpha2'      => 'KE',
            'alpha3'      => 'KEN',
            'numeric'     => '404',
            'currency'    => 'KES',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '0.1763369',
                'longitude' => '33.4121533',
            ],
        ],
        [
            'name'        => 'Kiribati',
            'alpha2'      => 'KI',
            'alpha3'      => 'KIR',
            'numeric'     => '296',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '1.8709198',
                'longitude' => '-157.6430476',
            ],
        ],
        [
            'name'        => 'Korea (Democratic People\'s Republic of)',
            'alpha2'      => 'KP',
            'alpha3'      => 'PRK',
            'numeric'     => '408',
            'currency'    => 'KPW',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '40.2556478',
                'longitude' => '122.9697722',
            ],
        ],
        [
            'name'        => 'Korea (Republic of)',
            'alpha2'      => 'KR',
            'alpha3'      => 'KOR',
            'numeric'     => '410',
            'currency'    => 'KRW',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '35.7779502',
                'longitude' => '122.606685',
            ],
        ],
        [
            'name'        => 'Kuwait',
            'alpha2'      => 'KW',
            'alpha3'      => 'KWT',
            'numeric'     => '414',
            'currency'    => 'KWD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '29.3093938',
                'longitude' => '46.3767478',
            ],
        ],
        [
            'name'        => 'Kyrgyzstan',
            'alpha2'      => 'KG',
            'alpha3'      => 'KGZ',
            'numeric'     => '417',
            'currency'    => 'KGS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '40.8727298',
                'longitude' => '65.7571729',
            ],
        ],
        [
            'name'        => 'Lao People\'s Democratic Republic',
            'alpha2'      => 'LA',
            'alpha3'      => 'LAO',
            'numeric'     => '418',
            'currency'    => 'LAK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.1539891',
                'longitude' => '99.3946231',
            ],
        ],
        [
            'name'        => 'Latvia',
            'alpha2'      => 'LV',
            'alpha3'      => 'LVA',
            'numeric'     => '428',
            'currency'    => 'LVL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '56.7998008',
                'longitude' => '20.1233607',
            ],
        ],
        [
            'name'        => 'Lebanon',
            'alpha2'      => 'LB',
            'alpha3'      => 'LBN',
            'numeric'     => '422',
            'currency'    => 'LBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '33.8684821',
                'longitude' => '34.7426647',
            ],
        ],
        [
            'name'             => 'Lesotho',
            'alpha2'           => 'LS',
            'alpha3'           => 'LSO',
            'numeric'          => '426',
            'currency'         => [
                'LSL',
                'ZAR',
            ],
            'enabled'          => false,
            'primary_currency' => 'LSL',
            'coordinates'      => [
                'latitude'  => '-29.6184768',
                'longitude' => '27.1123489',
            ],
        ],
        [
            'name'        => 'Liberia',
            'alpha2'      => 'LR',
            'alpha3'      => 'LBR',
            'numeric'     => '430',
            'currency'    => 'LRD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '6.4288074',
                'longitude' => '-11.6664631',
            ],
        ],
        [
            'name'        => 'Libya',
            'alpha2'      => 'LY',
            'alpha3'      => 'LBY',
            'numeric'     => '434',
            'currency'    => 'LYD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '26.0520475',
                'longitude' => '8.2571069',
            ],
        ],
        [
            'name'        => 'Liechtenstein',
            'alpha2'      => 'LI',
            'alpha3'      => 'LIE',
            'numeric'     => '438',
            'currency'    => 'CHF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '47.159333',
                'longitude' => '9.4135534',
            ],
        ],
        [
            'name'        => 'Lithuania',
            'alpha2'      => 'LT',
            'alpha3'      => 'LTU',
            'numeric'     => '440',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '55.0912522',
                'longitude' => '19.4118127',
            ],
        ],
        [
            'name'        => 'Luxembourg',
            'alpha2'      => 'LU',
            'alpha3'      => 'LUX',
            'numeric'     => '442',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '49.8139485',
                'longitude' => '5.5729319',
            ],
        ],
        [
            'name'        => 'Macao',
            'alpha2'      => 'MO',
            'alpha3'      => 'MAC',
            'numeric'     => '446',
            'currency'    => 'MOP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '22.1634129',
                'longitude' => '113.5284455',
            ],
        ],
        [
            'name'        => 'Macedonia, the former Yugoslav Republic of',
            'alpha2'      => 'MK',
            'alpha3'      => 'MKD',
            'numeric'     => '807',
            'currency'    => 'MKD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '41.0982491',
                'longitude' => '19.9932374',
            ],
        ],
        [
            'name'        => 'Madagascar',
            'alpha2'      => 'MG',
            'alpha3'      => 'MDG',
            'numeric'     => '450',
            'currency'    => 'MGA',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-18.7255269',
                'longitude' => '42.3401734',
            ],
        ],
        [
            'name'        => 'Malawi',
            'alpha2'      => 'MW',
            'alpha3'      => 'MWI',
            'numeric'     => '454',
            'currency'    => 'MWK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-13.2385883',
                'longitude' => '32.0516264',
            ],
        ],
        [
            'name'        => 'Malaysia',
            'alpha2'      => 'MY',
            'alpha3'      => 'MYS',
            'numeric'     => '458',
            'currency'    => 'MYR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '3.92983',
                'longitude' => '91.2269762',
            ],
        ],
        [
            'name'        => 'Maldives',
            'alpha2'      => 'MV',
            'alpha3'      => 'MDV',
            'numeric'     => '462',
            'currency'    => 'MVR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '1.9772217',
                'longitude' => '73.3960163',
            ],
        ],
        [
            'name'        => 'Mali',
            'alpha2'      => 'ML',
            'alpha3'      => 'MLI',
            'numeric'     => '466',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '17.3699332',
                'longitude' => '-13.0130668',
            ],
        ],
        [
            'name'        => 'Malta',
            'alpha2'      => 'MT',
            'alpha3'      => 'MLT',
            'numeric'     => '470',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '35.9439061',
                'longitude' => '14.0998454',
            ],
        ],
        [
            'name'        => 'Marshall Islands',
            'alpha2'      => 'MH',
            'alpha3'      => 'MHL',
            'numeric'     => '584',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '11.3245589',
                'longitude' => '166.5615551',
            ],
        ],
        [
            'name'        => 'Martinique',
            'alpha2'      => 'MQ',
            'alpha3'      => 'MTQ',
            'numeric'     => '474',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '14.6335142',
                'longitude' => '-61.3000095',
            ],
        ],
        [
            'name'        => 'Mauritania',
            'alpha2'      => 'MR',
            'alpha3'      => 'MRT',
            'numeric'     => '478',
            'currency'    => 'MRO',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '20.7808581',
                'longitude' => '-19.9735293',
            ],
        ],
        [
            'name'        => 'Mauritius',
            'alpha2'      => 'MU',
            'alpha3'      => 'MUS',
            'numeric'     => '480',
            'currency'    => 'MUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-20.1924098',
                'longitude' => '55.4317747',
            ],
        ],
        [
            'name'        => 'Mayotte',
            'alpha2'      => 'YT',
            'alpha3'      => 'MYT',
            'numeric'     => '175',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-12.8209326',
                'longitude' => '45.0189878',
            ],
        ],
        [
            'name'        => 'Mexico',
            'alpha2'      => 'MX',
            'alpha3'      => 'MEX',
            'numeric'     => '484',
            'currency'    => 'MXN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '22.5614881',
                'longitude' => '-120.7712027',
            ],
        ],
        [
            'name'        => 'Micronesia (Federated States of)',
            'alpha2'      => 'FM',
            'alpha3'      => 'FSM',
            'numeric'     => '583',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '6.8874377',
                'longitude' => '158.0824383',
            ],
        ],
        [
            'name'        => 'Moldova (Republic of)',
            'alpha2'      => 'MD',
            'alpha3'      => 'MDA',
            'numeric'     => '498',
            'currency'    => 'MDL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '46.9575294',
                'longitude' => '26.1472724',
            ],
        ],
        [
            'name'        => 'Monaco',
            'alpha2'      => 'MC',
            'alpha3'      => 'MCO',
            'numeric'     => '492',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '43.7383216',
                'longitude' => '7.4069485',
            ],
        ],
        [
            'name'        => 'Mongolia',
            'alpha2'      => 'MN',
            'alpha3'      => 'MNG',
            'numeric'     => '496',
            'currency'    => 'MNT',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '45.4510881',
                'longitude' => '85.9725',
            ],
        ],
        [
            'name'        => 'Montenegro',
            'alpha2'      => 'ME',
            'alpha3'      => 'MNE',
            'numeric'     => '499',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '42.6989565',
                'longitude' => '18.2746417',
            ],
        ],
        [
            'name'        => 'Montserrat',
            'alpha2'      => 'MS',
            'alpha3'      => 'MSR',
            'numeric'     => '500',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '16.7493621',
                'longitude' => '-62.2628864',
            ],
        ],
        [
            'name'        => 'Morocco',
            'alpha2'      => 'MA',
            'alpha3'      => 'MAR',
            'numeric'     => '504',
            'currency'    => 'MAD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '31.4776803',
                'longitude' => '-16.0873232',
            ],
        ],
        [
            'name'        => 'Mozambique',
            'alpha2'      => 'MZ',
            'alpha3'      => 'MOZ',
            'numeric'     => '508',
            'currency'    => 'MZN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-18.4547278',
                'longitude' => '26.5014974',
            ],
        ],
        [
            'name'        => 'Myanmar',
            'alpha2'      => 'MM',
            'alpha3'      => 'MMR',
            'numeric'     => '104',
            'currency'    => 'MMK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.8576151',
                'longitude' => '87.6456355',
            ],
        ],
        [
            'name'             => 'Namibia',
            'alpha2'           => 'NA',
            'alpha3'           => 'NAM',
            'numeric'          => '516',
            'currency'         => [
                'NAD',
                'ZAR',
            ],
            'enabled'          => false,
            'primary_currency' => 'NAD',
            'coordinates'      => [
                'latitude'  => '-22.7120697',
                'longitude' => '9.4798569',
            ],
        ],
        [
            'name'        => 'Nauru',
            'alpha2'      => 'NR',
            'alpha3'      => 'NRU',
            'numeric'     => '520',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-0.5284144',
                'longitude' => '166.8992189',
            ],
        ],
        [
            'name'        => 'Nepal',
            'alpha2'      => 'NP',
            'alpha3'      => 'NPL',
            'numeric'     => '524',
            'currency'    => 'NPR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '28.3237758',
                'longitude' => '79.6380248',
            ],
        ],
        [
            'name'        => 'Netherlands',
            'alpha2'      => 'NL',
            'alpha3'      => 'NLD',
            'numeric'     => '528',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '52.1917413',
                'longitude' => '3.0372593',
            ],
        ],
        [
            'name'        => 'New Caledonia',
            'alpha2'      => 'NC',
            'alpha3'      => 'NCL',
            'numeric'     => '540',
            'currency'    => 'XPF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-21.1959112',
                'longitude' => '163.6080103',
            ],
        ],
        [
            'name'        => 'New Zealand',
            'alpha2'      => 'NZ',
            'alpha3'      => 'NZL',
            'numeric'     => '554',
            'currency'    => 'NZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-43.0222641',
                'longitude' => '163.473274',
            ],
        ],
        [
            'name'        => 'Nicaragua',
            'alpha2'      => 'NI',
            'alpha3'      => 'NIC',
            'numeric'     => '558',
            'currency'    => 'NIO',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '12.830889',
                'longitude' => '-89.6364835',
            ],
        ],
        [
            'name'        => 'Niger',
            'alpha2'      => 'NE',
            'alpha3'      => 'NER',
            'numeric'     => '562',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '17.3921371',
                'longitude' => '-0.9469101',
            ],
        ],
        [
            'name'        => 'Nigeria',
            'alpha2'      => 'NG',
            'alpha3'      => 'NGA',
            'numeric'     => '566',
            'currency'    => 'NGN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '8.9669352',
                'longitude' => '-0.3585989',
            ],
        ],
        [
            'name'        => 'Niue',
            'alpha2'      => 'NU',
            'alpha3'      => 'NIU',
            'numeric'     => '570',
            'currency'    => 'NZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-19.0540005',
                'longitude' => '-170.0021428',
            ],
        ],
        [
            'name'        => 'Norfolk Island',
            'alpha2'      => 'NF',
            'alpha3'      => 'NFK',
            'numeric'     => '574',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-29.0346877',
                'longitude' => '-29.0346877',
            ],
        ],
        [
            'name'        => 'Northern Mariana Islands',
            'alpha2'      => 'MP',
            'alpha3'      => 'MNP',
            'numeric'     => '580',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.1063817',
                'longitude' => '145.566164',
            ],
        ],
        [
            'name'        => 'Norway',
            'alpha2'      => 'NO',
            'alpha3'      => 'NOR',
            'numeric'     => '578',
            'currency'    => 'NOK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '63.4920883',
                'longitude' => '0.2399173',
            ],
        ],
        [
            'name'        => 'Oman',
            'alpha2'      => 'OM',
            'alpha3'      => 'OMN',
            'numeric'     => '512',
            'currency'    => 'OMR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '21.4677103',
                'longitude' => '51.4259974',
            ],
        ],
        [
            'name'        => 'Pakistan',
            'alpha2'      => 'PK',
            'alpha3'      => 'PAK',
            'numeric'     => '586',
            'currency'    => 'PKR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '30.0836793',
                'longitude' => '60.346814',
            ],
        ],
        [
            'name'        => 'Palau',
            'alpha2'      => 'PW',
            'alpha3'      => 'PLW',
            'numeric'     => '585',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '7.3662658',
                'longitude' => '134.1539596',
            ],
        ],
        [
            'name'        => 'Palestine, State of',
            'alpha2'      => 'PS',
            'alpha3'      => 'PSE',
            'numeric'     => '275',
            'currency'    => 'ILS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '31.9461203',
                'longitude' => '34.6667378',
            ],
        ],
        [
            'name'        => 'Panama',
            'alpha2'      => 'PA',
            'alpha3'      => 'PAN',
            'numeric'     => '591',
            'currency'    => 'PAB',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '8.3999784',
                'longitude' => '-84.6011806',
            ],
        ],
        [
            'name'        => 'Papua New Guinea',
            'alpha2'      => 'PG',
            'alpha3'      => 'PNG',
            'numeric'     => '598',
            'currency'    => 'PGK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-6.1874223',
                'longitude' => '139.9260804',
            ],
        ],
        [
            'name'        => 'Paraguay',
            'alpha2'      => 'PY',
            'alpha3'      => 'PRY',
            'numeric'     => '600',
            'currency'    => 'PYG',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-23.3704209',
                'longitude' => '-62.9416123',
            ],
        ],
        [
            'name'        => 'Peru',
            'alpha2'      => 'PE',
            'alpha3'      => 'PER',
            'numeric'     => '604',
            'currency'    => 'PEN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-9.0830326',
                'longitude' => '-84.0263877',
            ],
        ],
        [
            'name'        => 'Philippines',
            'alpha2'      => 'PH',
            'alpha3'      => 'PHL',
            'numeric'     => '608',
            'currency'    => 'PHP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '11.5566572',
                'longitude' => '113.587835',
            ],
        ],
        [
            'name'        => 'Pitcairn',
            'alpha2'      => 'PN',
            'alpha3'      => 'PCN',
            'numeric'     => '612',
            'currency'    => 'NZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-24.3767307',
                'longitude' => '-128.3592655',
            ],
        ],
        [
            'name'        => 'Poland',
            'alpha2'      => 'PL',
            'alpha3'      => 'POL',
            'numeric'     => '616',
            'currency'    => 'PLN',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '51.5771776',
                'longitude' => '10.178158',
            ],
        ],
        [
            'name'        => 'Portugal',
            'alpha2'      => 'PT',
            'alpha3'      => 'PRT',
            'numeric'     => '620',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '39.5355335',
                'longitude' => '-10.0964421',
            ],
        ],
        [
            'name'        => 'Puerto Rico',
            'alpha2'      => 'PR',
            'alpha3'      => 'PRI',
            'numeric'     => '630',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.1954665',
                'longitude' => '-67.4738734',
            ],
        ],
        [
            'name'        => 'Qatar',
            'alpha2'      => 'QA',
            'alpha3'      => 'QAT',
            'numeric'     => '634',
            'currency'    => 'QAR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '25.3260455',
                'longitude' => '50.6342254',
            ],
        ],
        [
            'name'        => 'Réunion',
            'alpha2'      => 'RE',
            'alpha3'      => 'REU',
            'numeric'     => '638',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-21.1297672',
                'longitude' => '54.9660382',
            ],
        ],
        [
            'name'        => 'Romania',
            'alpha2'      => 'RO',
            'alpha3'      => 'ROU',
            'numeric'     => '642',
            'currency'    => 'RON',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '45.8564203',
                'longitude' => '20.5231443',
            ],
        ],
        [
            'name'        => 'Russian Federation',
            'alpha2'      => 'RU',
            'alpha3'      => 'RUS',
            'numeric'     => '643',
            'currency'    => 'RUB',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '14.0335239',
                'longitude' => '40.9063098',
            ],
        ],
        [
            'name'        => 'Rwanda',
            'alpha2'      => 'RW',
            'alpha3'      => 'RWA',
            'numeric'     => '646',
            'currency'    => 'RWF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-1.9432849',
                'longitude' => '28.7591884',
            ],
        ],
        [
            'name'        => 'Saint Barthélemy',
            'alpha2'      => 'BL',
            'alpha3'      => 'BLM',
            'numeric'     => '652',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '17.9138963',
                'longitude' => '-62.9038921',
            ],
        ],
        [
            'name'        => 'Saint Helena, Ascension and Tristan da Cunha',
            'alpha2'      => 'SH',
            'alpha3'      => 'SHN',
            'numeric'     => '654',
            'currency'    => 'SHP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-15.96539',
                'longitude' => '-5.8516125',
            ],
        ],
        [
            'name'        => 'Saint Kitts and Nevis',
            'alpha2'      => 'KN',
            'alpha3'      => 'KNA',
            'numeric'     => '659',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '17.2558971',
                'longitude' => '-62.9821339',
            ],
        ],
        [
            'name'        => 'Saint Lucia',
            'alpha2'      => 'LC',
            'alpha3'      => 'LCA',
            'numeric'     => '662',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.909011',
                'longitude' => '-61.1166908',
            ],
        ],
        [
            'name'             => 'Saint Martin (French part)',
            'alpha2'           => 'MF',
            'alpha3'           => 'MAF',
            'numeric'          => '663',
            'currency'         => [
                'EUR',
                'USD',
            ],
            'enabled'          => false,
            'primary_currency' => 'EUR',
            'coordinates'      => [
                'latitude'  => '18.0647624',
                'longitude' => '-63.1518558',
            ],
        ],
        [
            'name'        => 'Saint Pierre and Miquelon',
            'alpha2'      => 'PM',
            'alpha3'      => 'SPM',
            'numeric'     => '666',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '46.9466027',
                'longitude' => '-56.4023665',
            ],
        ],
        [
            'name'        => 'Saint Vincent and the Grenadines',
            'alpha2'      => 'VC',
            'alpha3'      => 'VCT',
            'numeric'     => '670',
            'currency'    => 'XCD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.2527797',
                'longitude' => '-61.3372473',
            ],
        ],
        [
            'name'        => 'Samoa',
            'alpha2'      => 'WS',
            'alpha3'      => 'WSM',
            'numeric'     => '882',
            'currency'    => 'WST',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-13.7555588',
                'longitude' => '-173.2220605',
            ],
        ],
        [
            'name'        => 'San Marino',
            'alpha2'      => 'SM',
            'alpha3'      => 'SMR',
            'numeric'     => '674',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '43.9428566',
                'longitude' => '12.3900538',
            ],
        ],
        [
            'name'        => 'Sao Tome and Principe',
            'alpha2'      => 'ST',
            'alpha3'      => 'STP',
            'numeric'     => '678',
            'currency'    => 'STD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '0.1996946',
                'longitude' => '6.4704796',
            ],
        ],
        [
            'name'        => 'Saudi Arabia',
            'alpha2'      => 'SA',
            'alpha3'      => 'SAU',
            'numeric'     => '682',
            'currency'    => 'SAR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '23.0438518',
                'longitude' => '26.8823323',
            ],
        ],
        [
            'name'        => 'Senegal',
            'alpha2'      => 'SN',
            'alpha3'      => 'SEN',
            'numeric'     => '686',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '14.4574424',
                'longitude' => '-18.9346516',
            ],
        ],
        [
            'name'        => 'Serbia',
            'alpha2'      => 'RS',
            'alpha3'      => 'SRB',
            'numeric'     => '688',
            'currency'    => 'RSD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '44.1888264',
                'longitude' => '18.6798292',
            ],
        ],
        [
            'name'        => 'Seychelles',
            'alpha2'      => 'SC',
            'alpha3'      => 'SYC',
            'numeric'     => '690',
            'currency'    => 'SCR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-4.68379',
                'longitude' => '55.3093852',
            ],
        ],
        [
            'name'        => 'Sierra Leone',
            'alpha2'      => 'SL',
            'alpha3'      => 'SLE',
            'numeric'     => '694',
            'currency'    => 'SLL',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '8.4432679',
                'longitude' => '-14.0310675',
            ],
        ],
        [
            'name'        => 'Singapore',
            'alpha2'      => 'SG',
            'alpha3'      => 'SGP',
            'numeric'     => '702',
            'currency'    => 'SGD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '1.314715',
                'longitude' => '103.566831',
            ],
        ],
        [
            'name'        => 'Sint Maarten (Dutch part)',
            'alpha2'      => 'SX',
            'alpha3'      => 'SXM',
            'numeric'     => '534',
            'currency'    => 'ANG',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.034622',
                'longitude' => '-63.1381414',
            ],
        ],
        [
            'name'        => 'Slovakia',
            'alpha2'      => 'SK',
            'alpha3'      => 'SVK',
            'numeric'     => '703',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '48.5853153',
                'longitude' => '15.2107558',
            ],
        ],
        [
            'name'        => 'Slovenia',
            'alpha2'      => 'SI',
            'alpha3'      => 'SVN',
            'numeric'     => '705',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '46.1273172',
                'longitude' => '12.7505461',
            ],
        ],
        [
            'name'        => 'Solomon Islands',
            'alpha2'      => 'SB',
            'alpha3'      => 'SLB',
            'numeric'     => '090',
            'currency'    => 'SBD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-9.2073851',
                'longitude' => '154.6916541',
            ],
        ],
        [
            'name'        => 'Somalia',
            'alpha2'      => 'SO',
            'alpha3'      => 'SOM',
            'numeric'     => '706',
            'currency'    => 'SOS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '5.0995054',
                'longitude' => '37.1654332',
            ],
        ],
        [
            'name'        => 'South Africa',
            'alpha2'      => 'ZA',
            'alpha3'      => 'ZAF',
            'numeric'     => '710',
            'currency'    => 'ZAR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-28.1822255',
                'longitude' => '15.6630094',
            ],
        ],
        [
            'name'        => 'South Georgia and the South Sandwich Islands',
            'alpha2'      => 'GS',
            'alpha3'      => 'SGS',
            'numeric'     => '239',
            'currency'    => 'GBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-54.4174048',
                'longitude' => '-39.2288872',
            ],
        ],
        [
            'name'        => 'South Sudan',
            'alpha2'      => 'SS',
            'alpha3'      => 'SSD',
            'numeric'     => '728',
            'currency'    => 'SSP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '7.7662935',
                'longitude' => '20.6580534',
            ],
        ],
        [
            'name'        => 'Spain',
            'alpha2'      => 'ES',
            'alpha3'      => 'ESP',
            'numeric'     => '724',
            'currency'    => 'EUR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '39.8601785',
                'longitude' => '-12.6969547',
            ],
        ],
        [
            'name'        => 'Sri Lanka',
            'alpha2'      => 'LK',
            'alpha3'      => 'LKA',
            'numeric'     => '144',
            'currency'    => 'LKR',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '7.8757424',
                'longitude' => '79.5791041',
            ],
        ],
        [
            'name'        => 'Sudan',
            'alpha2'      => 'SD',
            'alpha3'      => 'SDN',
            'numeric'     => '729',
            'currency'    => 'SDG',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.6000208',
                'longitude' => '21.1697261',
            ],
        ],
        [
            'name'        => 'Suriname',
            'alpha2'      => 'SR',
            'alpha3'      => 'SUR',
            'numeric'     => '740',
            'currency'    => 'SRD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '3.9166543',
                'longitude' => '-58.2548235',
            ],
        ],
        [
            'name'        => 'Svalbard and Jan Mayen',
            'alpha2'      => 'SJ',
            'alpha3'      => 'SJM',
            'numeric'     => '744',
            'currency'    => 'NOK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '78.1031991',
                'longitude' => '4.5449903',
            ],
        ],
        [
            'name'             => 'Swaziland',
            'alpha2'           => 'SZ',
            'alpha3'           => 'SWZ',
            'numeric'          => '748',
            'currency'         => [
                'SZL',
                'ZAR',
            ],
            'enabled'          => false,
            'primary_currency' => 'SZL',
            'coordinates'      => [
                'latitude'  => '-26.5132788',
                'longitude' => '30.3416282',
            ],
        ],
        [
            'name'        => 'Sweden',
            'alpha2'      => 'SE',
            'alpha3'      => 'SWE',
            'numeric'     => '752',
            'currency'    => 'SEK',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '61.9094213',
                'longitude' => '8.6298161',
            ],
        ],
        [
            'name'        => 'Switzerland',
            'alpha2'      => 'CH',
            'alpha3'      => 'CHE',
            'numeric'     => '756',
            'currency'    => 'CHF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '46.7912841',
                'longitude' => '5.9817756',
            ],
        ],
        [
            'name'        => 'Syrian Arab Republic',
            'alpha2'      => 'SY',
            'alpha3'      => 'SYR',
            'numeric'     => '760',
            'currency'    => 'SYP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '34.7324082',
                'longitude' => '34.5563972',
            ],
        ],
        [
            'name'        => 'Taiwan (Province of China)',
            'alpha2'      => 'TW',
            'alpha3'      => 'TWN',
            'numeric'     => '158',
            'currency'    => 'TWD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '23.542241',
                'longitude' => '119.9209753',
            ],
        ],
        [
            'name'        => 'Tajikistan',
            'alpha2'      => 'TJ',
            'alpha3'      => 'TJK',
            'numeric'     => '762',
            'currency'    => 'TJS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '38.7722159',
                'longitude' => '66.7592513',
            ],
        ],
        [
            'name'        => 'Tanzania, United Republic of',
            'alpha2'      => 'TZ',
            'alpha3'      => 'TZA',
            'numeric'     => '834',
            'currency'    => 'TZS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-6.2943666',
                'longitude' => '25.8547709',
            ],
        ],
        [
            'name'        => 'Thailand',
            'alpha2'      => 'TH',
            'alpha3'      => 'THA',
            'numeric'     => '764',
            'currency'    => 'THB',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '13.0002088',
                'longitude' => '96.9948667',
            ],
        ],
        [
            'name'        => 'Timor-Leste',
            'alpha2'      => 'TL',
            'alpha3'      => 'TLS',
            'numeric'     => '626',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-8.7931071',
                'longitude' => '125.016167',
            ],
        ],
        [
            'name'        => 'Togo',
            'alpha2'      => 'TG',
            'alpha3'      => 'TGO',
            'numeric'     => '768',
            'currency'    => 'XOF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '8.6199298',
                'longitude' => '-1.4116207',
            ],
        ],
        [
            'name'        => 'Tokelau',
            'alpha2'      => 'TK',
            'alpha3'      => 'TKL',
            'numeric'     => '772',
            'currency'    => 'NZD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-9.166827',
                'longitude' => '-171.8882539',
            ],
        ],
        [
            'name'        => 'Tonga',
            'alpha2'      => 'TO',
            'alpha3'      => 'TON',
            'numeric'     => '776',
            'currency'    => 'TOP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-21.2579988',
                'longitude' => '-175.4087322',
            ],
        ],
        [
            'name'        => 'Trinidad and Tobago',
            'alpha2'      => 'TT',
            'alpha3'      => 'TTO',
            'numeric'     => '780',
            'currency'    => 'TTD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '10.4426595',
                'longitude' => '-61.9807257',
            ],
        ],
        [
            'name'        => 'Tunisia',
            'alpha2'      => 'TN',
            'alpha3'      => 'TUN',
            'numeric'     => '788',
            'currency'    => 'TND',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '33.7728619',
                'longitude' => '7.3176118',
            ],
        ],
        [
            'name'        => 'Turkey',
            'alpha2'      => 'TR',
            'alpha3'      => 'TUR',
            'numeric'     => '792',
            'currency'    => 'TRY',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '38.6119354',
                'longitude' => '26.2546451',
            ],
        ],
        [
            'name'        => 'Turkmenistan',
            'alpha2'      => 'TM',
            'alpha3'      => 'TKM',
            'numeric'     => '795',
            'currency'    => 'TMT',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '38.6182327',
                'longitude' => '50.5907705',
            ],
        ],
        [
            'name'        => 'Turks and Caicos Islands',
            'alpha2'      => 'TC',
            'alpha3'      => 'TCA',
            'numeric'     => '796',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '21.7072467',
                'longitude' => '-72.5325575',
            ],
        ],
        [
            'name'        => 'Tuvalu',
            'alpha2'      => 'TV',
            'alpha3'      => 'TUV',
            'numeric'     => '798',
            'currency'    => 'AUD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-7.4784202',
                'longitude' => '178.6624144',
            ],
        ],
        [
            'name'        => 'Uganda',
            'alpha2'      => 'UG',
            'alpha3'      => 'UGA',
            'numeric'     => '800',
            'currency'    => 'UGX',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '1.3639461',
                'longitude' => '27.8070382',
            ],
        ],
        [
            'name'        => 'Ukraine',
            'alpha2'      => 'UA',
            'alpha3'      => 'UKR',
            'numeric'     => '804',
            'currency'    => 'UAH',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '48.0331251',
                'longitude' => '22.2182554',
            ],
        ],
        [
            'name'        => 'United Arab Emirates',
            'alpha2'      => 'AE',
            'alpha3'      => 'ARE',
            'numeric'     => '784',
            'currency'    => 'AED',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '24.3340728',
                'longitude' => '51.6960757',
            ],
        ],
        [
            'name'        => 'United Kingdom of Great Britain and Northern Ireland',
            'alpha2'      => 'GB',
            'alpha3'      => 'GBR',
            'numeric'     => '826',
            'currency'    => 'GBP',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '55.0398133',
                'longitude' => '-12.3913901',
            ],
        ],
        [
            'name'        => 'United States of America',
            'alpha2'      => 'US',
            'alpha3'      => 'USA',
            'numeric'     => '840',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '31.8276499',
                'longitude' => '-131.9591883',
            ],
        ],
        [
            'name'        => 'United States Minor Outlying Islands',
            'alpha2'      => 'UM',
            'alpha3'      => 'UMI',
            'numeric'     => '581',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '19.2944482',
                'longitude' => '166.5922697',
            ],
        ],
        [
            'name'        => 'Uruguay',
            'alpha2'      => 'UY',
            'alpha3'      => 'URY',
            'numeric'     => '858',
            'currency'    => 'UYU',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-32.4784834',
                'longitude' => '-60.3024516',
            ],
        ],
        [
            'name'        => 'Uzbekistan',
            'alpha2'      => 'UZ',
            'alpha3'      => 'UZB',
            'numeric'     => '860',
            'currency'    => 'UZS',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '41.0308563',
                'longitude' => '55.5923601',
            ],
        ],
        [
            'name'        => 'Vanuatu',
            'alpha2'      => 'VU',
            'alpha3'      => 'VUT',
            'numeric'     => '548',
            'currency'    => 'VUV',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-15.4463969',
                'longitude' => '166.4741988',
            ],
        ],
        [
            'name'        => 'Venezuela (Bolivarian Republic of)',
            'alpha2'      => 'VE',
            'alpha3'      => 'VEN',
            'numeric'     => '862',
            'currency'    => 'VEF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '6.5751973',
                'longitude' => '-75.652235',
            ],
        ],
        [
            'name'        => 'Vietnam',
            'alpha2'      => 'VN',
            'alpha3'      => 'VNM',
            'numeric'     => '704',
            'currency'    => 'VND',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.8563707',
                'longitude' => '101.3118374',
            ],
        ],
        [
            'name'        => 'Virgin Islands (British)',
            'alpha2'      => 'VG',
            'alpha3'      => 'VGB',
            'numeric'     => '092',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.4178839',
                'longitude' => '-64.8656171',
            ],
        ],
        [
            'name'        => 'Virgin Islands (U.S.)',
            'alpha2'      => 'VI',
            'alpha3'      => 'VIR',
            'numeric'     => '850',
            'currency'    => 'USD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '18.0635459',
                'longitude' => '-65.8598839',
            ],
        ],
        [
            'name'        => 'Wallis and Futuna',
            'alpha2'      => 'WF',
            'alpha3'      => 'WLF',
            'numeric'     => '876',
            'currency'    => 'XPF',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-14.3013402',
                'longitude' => '-178.230947',
            ],
        ],
        [
            'name'        => 'Western Sahara',
            'alpha2'      => 'EH',
            'alpha3'      => 'ESH',
            'numeric'     => '732',
            'currency'    => 'MAD',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '24.1527985',
                'longitude' => '-17.3790971',
            ],
        ],
        [
            'name'        => 'Yemen',
            'alpha2'      => 'YE',
            'alpha3'      => 'YEM',
            'numeric'     => '887',
            'currency'    => 'YER',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '15.3703113',
                'longitude' => '39.1452312',
            ],
        ],
        [
            'name'        => 'Zambia',
            'alpha2'      => 'ZM',
            'alpha3'      => 'ZMB',
            'numeric'     => '894',
            'currency'    => 'ZMW',
            'enabled'     => true,
            'coordinates' => [
                'latitude'  => '-12.982956',
                'longitude' => '18.8216654',
            ],
        ],
        [
            'name'             => 'Zimbabwe',
            'alpha2'           => 'ZW',
            'alpha3'           => 'ZWE',
            'numeric'          => '716',
            'currency'         => [
                'BWP',
                'EUR',
                'GBP',
                'USD',
                'ZAR',
            ],
            'enabled'          => false,
            'primary_currency' => '', // Zimbabwe has no official currency
            'coordinates'      => [
                'latitude'  => '-18.9615492',
                'longitude' => '24.6585631',
            ],
        ],
    ];
}