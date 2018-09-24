<?php

namespace Keet\Country\Factory\Fieldset;

use Keet\Country\Entity\Language;
use Keet\Country\Fieldset\LanguageFieldset;
use Keet\Form\Factory\AbstractDoctrineFieldsetFactory;

class LanguageFieldsetFactory extends AbstractDoctrineFieldsetFactory
{
    public function __construct()
    {
        parent::__construct(LanguageFieldset::class, 'language', Language::class);
    }
}