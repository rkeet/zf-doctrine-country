<?php

namespace Keet\Country\Factory\Fieldset;

use Keet\Country\Entity\Currency;
use Keet\Country\Fieldset\CurrencyFieldset;
use Keet\Form\Factory\AbstractDoctrineFieldsetFactory;

class CurrencyFieldsetFactory extends AbstractDoctrineFieldsetFactory
{
    public function __construct()
    {
        parent::__construct(CurrencyFieldset::class, 'currency', Currency::class);
    }
}