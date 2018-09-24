<?php

namespace Keet\Country\InputFilter\Fieldset;

use Keet\Form\InputFilter\AbstractDoctrineFieldsetInputFilter;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToNull;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;

class LanguageFieldsetInputFilter extends AbstractDoctrineFieldsetInputFilter
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
                            'min' => 2,
                            'max' => 10,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'direction',
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
                'name'       => 'localName',
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
    }
}