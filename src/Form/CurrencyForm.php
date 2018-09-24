<?php

namespace Keet\Country\Form;

use Keet\Country\Fieldset\CurrencyFieldset;
use Keet\Form\Form\AbstractDoctrineForm;

class CurrencyForm extends AbstractDoctrineForm
{
    public function init()
    {
        $this->add(
            [
                'name'    => 'currency',
                'type'    => CurrencyFieldset::class,
                'options' => [
                    'use_as_base_fieldset' => true,
                ],
            ]
        );

        //Call parent initializer. Check in parent what it does.
        parent::init();
    }
}