<?php

namespace Keet\Country\Factory\Form;

use Keet\Country\Form\CountryForm;
use Keet\Country\InputFilter\Form\CountryFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormFactory;

class CountryFormFactory extends AbstractDoctrineFormFactory
{
    public function __construct()
    {
        parent::__construct(CountryForm::class, CountryFormInputFilter::class);
    }
}