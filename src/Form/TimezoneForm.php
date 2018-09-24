<?php

namespace Keet\Country\Form;

use Keet\Country\Fieldset\TimezoneFieldset;
use Keet\Form\Form\AbstractDoctrineForm;

class TimezoneForm extends AbstractDoctrineForm
{
    public function init()
    {
        $this->add(
            [
                'name'    => 'timezone',
                'type'    => TimezoneFieldset::class,
                'options' => [
                    'use_as_base_fieldset' => true,
                ],
            ]
        );

        //Call parent initializer. Check in parent what it does.
        parent::init();
    }
}