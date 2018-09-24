<?php

namespace Keet\Country\Factory\Fieldset;

use Keet\Country\Entity\Timezone;
use Keet\Country\Fieldset\TimezoneFieldset;
use Keet\Form\Factory\AbstractDoctrineFieldsetFactory;

class TimezoneFieldsetFactory extends AbstractDoctrineFieldsetFactory
{
    public function __construct()
    {
        parent::__construct(TimezoneFieldset::class, 'timezone', Timezone::class);
    }
}