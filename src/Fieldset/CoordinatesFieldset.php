<?php

namespace Keet\Country\Fieldset;

use Keet\Form\Fieldset\AbstractDoctrineFieldset;
use Zend\Form\Element\Text;

class CoordinatesFieldset extends AbstractDoctrineFieldset
{
    public function init()
    {
        parent::init();

        $this->add(
            [
                'name'     => 'latitude',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Latitude'),
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'longitude',
                'required' => true,
                'type'     => Text::class,
                'options'  => [
                    'label' => _('Longitude'),
                ],
            ]
        );
    }
}