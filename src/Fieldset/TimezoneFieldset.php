<?php

namespace Keet\Country\Fieldset;

use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use Keet\Country\Entity\Country;
use Keet\Form\Fieldset\AbstractDoctrineFieldset;
use Zend\Form\Element\Text;

class TimezoneFieldset extends AbstractDoctrineFieldset
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
                'name'     => 'abbreviation',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Abbreviation'),
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