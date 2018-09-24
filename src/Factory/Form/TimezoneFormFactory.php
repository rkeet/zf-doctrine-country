<?php

namespace Keet\Country\Factory\Form;

use Keet\Country\Form\TimezoneForm;
use Keet\Country\InputFilter\Form\TimezoneFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormFactory;

class TimezoneFormFactory extends AbstractDoctrineFormFactory
{
    public function __construct()
    {
        parent::__construct(TimezoneForm::class, TimezoneFormInputFilter::class);
    }
}