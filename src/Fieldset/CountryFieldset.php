<?php

namespace Keet\Country\Fieldset;

use DoctrineModule\Form\Element\ObjectSelect;
use Keet\Country\Entity\Currency;
use Keet\Form\Fieldset\AbstractDoctrineFieldset;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Number;
use Zend\Form\Element\Text;

class CountryFieldset extends AbstractDoctrineFieldset
{
    public function init()
    {
        parent::init();

        $this->add(
            [
                'name'     => 'name',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Name'),
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'alpha2',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Alpha 2'),
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'alpha3',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Alpha 3'),
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'numeric',
                'required'   => true,
                'type'       => Number::class,
                'options'    => [
                    'label' => _('Numeric'),
                ],
                'attributes' => [
                    'step' => 1,
                    'min'  => 0,
                    'max'  => 999,
                ],
            ]
        );

        $this->add(
            [
                'type'    => ObjectSelect::class,
                'name'    => 'currency',
                'options' => [
                    'object_manager'     => $this->getEntityManager(),
                    'target_class'       => Currency::class,
                    'property'           => 'id',
                    'is_method'          => true,
                    'find_method'        => [
                        'name' => 'getEnabledCurrencies',
                    ],
                    'display_empty_item' => true,
                    'empty_item_label'   => '---',
                    'label'              => _('Currency'),
                    'label_generator'    => function ($targetEntity) {
                        /** @var Currency $targetEntity */
                        return $targetEntity->getName() . ' (' . $targetEntity->getCode() . ')';
                    },
                ],
            ]
        );

        $this->add(
            [
                'type'    => CoordinatesFieldset::class,
                'name'    => 'coordinates',
                'options' => [
                    'use_as_base_fieldset' => false,
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'enabled',
                'required' => true,
                'type'     => Checkbox::class,
                'options'  => [
                    'label'              => _('Enabled'),
                    'use_hidden_element' => true,
                    'checked_value'      => 1,
                    'unchecked_value'    => 0,
                ],
            ]
        );
    }
}