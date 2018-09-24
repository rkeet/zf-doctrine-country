<?php

namespace Keet\Country\InputFilter\Fieldset;

use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\Entity\Country;
use Keet\Form\InputFilter\AbstractDoctrineFieldsetInputFilter;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Filter\ToNull;
use Zend\I18n\Validator\IsInt;
use Zend\Mvc\I18n\Translator;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;

class CountryFieldsetInputFilter extends AbstractDoctrineFieldsetInputFilter
{
    /**
     * @var CoordinatesFieldsetInputFilter
     */
    protected $coordinatesFieldsetInputFilter;

    public function __construct(
        ObjectManager $objectManager,
        Translator $translator,
        CoordinatesFieldsetInputFilter $filter
    ) {
        $this->coordinatesFieldsetInputFilter = $filter;

        parent::__construct(
            [
                'object_manager'    => $objectManager,
                'object_repository' => $objectManager->getRepository(Country::class),
                'translator'        => $translator,
            ]
        );
    }

    public function init()
    {
        parent::init();

        $this->add($this->coordinatesFieldsetInputFilter, 'coordinates');

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
                'name'       => 'alpha2',
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
                            'max' => 2,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'alpha3',
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