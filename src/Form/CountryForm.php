<?php

namespace Keet\Country\Form;

use Keet\Country\Fieldset\CountryFieldset;
use Keet\Form\Form\AbstractDoctrineForm;

class CountryForm extends AbstractDoctrineForm
{
    public function init()
    {
        $this->add(
            [
                'name'    => 'country',
                'type'    => CountryFieldset::class,
                'options' => [
                    'use_as_base_fieldset' => true,
                ],
            ]
        );

        //Call parent initializer. Check in parent what it does.
        parent::init();
    }
}