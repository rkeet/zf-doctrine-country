<?php

namespace Keet\Country\Form;

use Keet\Country\Fieldset\CoordinatesFieldset;
use Keet\Form\Form\AbstractDoctrineForm;

class CoordinatesForm extends AbstractDoctrineForm
{
    public function init()
    {
        $this->add(
            [
                'name'    => 'coordinates',
                'type'    => CoordinatesFieldset::class,
                'options' => [
                    'use_as_base_fieldset' => true,
                ],
            ]
        );

        //Call parent initializer. Check in parent what it does.
        parent::init();
    }
}