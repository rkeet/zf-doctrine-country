<?php

namespace Keet\Country\InputFilter\Fieldset;

use Keet\Form\InputFilter\AbstractDoctrineFieldsetInputFilter;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToNull;
use Zend\Validator\StringLength;

class TimezoneFieldsetInputFilter extends AbstractDoctrineFieldsetInputFilter
{
    public function init()
    {
        parent::init();

        $this->add(
            [
                'name'       => 'name',
                'required'   => true,
                'filters'    => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class],
                    [
                        'name'    => ToNull::class,
                        'options' => [
                            'type' => ToNull::TYPE_STRING,
                        ],
                    ],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'max' => 100,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'abbreviation',
                'required'   => true,
                'filters'    => [
                    ['name' => StringTrim::class],
                    ['name' => StripTags::class],
                    [
                        'name'    => ToNull::class,
                        'options' => [
                            'type' => ToNull::TYPE_STRING,
                        ],
                    ],
                ],
                'validators' => [
                    [
                        'name'    => StringLength::class,
                        'options' => [
                            'max' => 10,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'timezone',
                'required' => false,
            ]
        );
    }
}