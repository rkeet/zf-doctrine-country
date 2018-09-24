<?php

namespace Keet\Country\InputFilter\Fieldset;

use Keet\Form\InputFilter\AbstractDoctrineFieldsetInputFilter;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Filter\ToNull;
use Zend\I18n\Validator\IsInt;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;

class CurrencyFieldsetInputFilter extends AbstractDoctrineFieldsetInputFilter
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
                            'min' => 3,
                            'max' => 255,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'code',
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
                            'min' => 3,
                            'max' => 3,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'numeric',
                'required'   => true,
                'filters'    => [
                    ['name' => ToInt::class],
                    [
                        'name'    => ToNull::class,
                        'options' => [
                            'type' => ToNull::TYPE_INTEGER,
                        ],
                    ],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'decimals',
                'required'   => true,
                'filters'    => [
                    ['name' => ToInt::class],
                    [
                        'name'    => ToNull::class,
                        'options' => [
                            'type' => ToNull::TYPE_INTEGER,
                        ],
                    ],
                ],
                'validators' => [
                    ['name' => IsInt::class],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'enabled',
                'required'   => true,
                'validators' => [
                    [
                        'name'    => InArray::class,
                        'options' => [
                            'haystack' => [true, false],
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'countries',
                'required' => false,
            ]
        );
    }
}