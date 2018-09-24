<?php

namespace Keet\Country\Form;

use Keet\Country\Fieldset\LanguageFieldset;
use Keet\Form\Form\AbstractDoctrineForm;

class LanguageForm extends AbstractDoctrineForm
{
    public function init()
    {
        $this->add(
            [
                'name'    => 'language',
                'type'    => LanguageFieldset::class,
                'options' => [
                    'use_as_base_fieldset' => true,
                ],
            ]
        );

        //Call parent initializer. Check in parent what it does.
        parent::init();
    }
}