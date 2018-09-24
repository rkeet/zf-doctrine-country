<?php

namespace Keet\Country\Factory\Form;

use Keet\Country\Form\CoordinatesForm;
use Keet\Country\InputFilter\Form\CoordinatesFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormFactory;

class CoordinatesFormFactory extends AbstractDoctrineFormFactory
{
    public function __construct()
    {
        parent::__construct(CoordinatesForm::class, CoordinatesFormInputFilter::class);
    }
}