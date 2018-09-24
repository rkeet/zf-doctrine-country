<?php

namespace Keet\Country\Factory\Form;

use Keet\Country\Form\LanguageForm;
use Keet\Country\InputFilter\Form\LanguageFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormFactory;

class LanguageFormFactory extends AbstractDoctrineFormFactory
{
    public function __construct()
    {
        parent::__construct(LanguageForm::class, LanguageFormInputFilter::class);
    }
}