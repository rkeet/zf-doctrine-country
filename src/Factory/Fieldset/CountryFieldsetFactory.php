<?php

namespace Keet\Country\Factory\Fieldset;

use Keet\Country\Entity\Country;
use Keet\Country\Fieldset\CountryFieldset;
use Keet\Form\Factory\AbstractDoctrineFieldsetFactory;

class CountryFieldsetFactory extends AbstractDoctrineFieldsetFactory
{
    public function __construct()
    {
        parent::__construct(CountryFieldset::class, 'country', Country::class);
    }
}