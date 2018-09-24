<?php

namespace Keet\Country\Factory\Form;

use Keet\Country\Form\CurrencyForm;
use Keet\Country\InputFilter\Form\CurrencyFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormFactory;

class CurrencyFormFactory extends AbstractDoctrineFormFactory
{
    public function __construct()
    {
        parent::__construct(CurrencyForm::class, CurrencyFormInputFilter::class);
    }
}