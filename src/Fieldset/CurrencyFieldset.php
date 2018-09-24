<?php

namespace Keet\Country\Fieldset;

use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use Keet\Country\Entity\Country;
use Keet\Form\Fieldset\AbstractDoctrineFieldset;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Number;
use Zend\Form\Element\Text;

class CurrencyFieldset extends AbstractDoctrineFieldset
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
                'name'     => 'code',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Code'),
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
                'name'       => 'decimals',
                'required'   => true,
                'type'       => Number::class,
                'options'    => [
                    'label' => _('Decimals'),
                ],
                'attributes' => [
                    'step' => 1,
                    'min'  => 0,
                    'max'  => 99,
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

        $this->add(
            [
                'name'     => 'countries',
                'required' => false,
                'type'     => ObjectMultiCheckbox::class,
                'options'  => [
                    'object_manager'     => $this->getEntityManager(),
                    'target_class'       => Country::class,
                    'property'           => 'id',
                    'display_empty_item' => true,
                    'empty_item_label'   => '---',
                    'label'              => _('Countries'),
                    'label_generator'    => function ($targetEntity) {
                        /** @var Country $targetEntity */
                        return $targetEntity->getName();
                    },
                ],
            ]
        );
    }
}