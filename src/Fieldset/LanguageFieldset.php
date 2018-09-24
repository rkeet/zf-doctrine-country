<?php

namespace Keet\Country\Fieldset;

use Keet\Form\Fieldset\AbstractDoctrineFieldset;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Text;

class LanguageFieldset extends AbstractDoctrineFieldset
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
                'name'     => 'direction',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Read direction'),
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'localName',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Local name'),
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