<?php

namespace Keet\Country\Factory\Fieldset;

use Keet\Country\Entity\Coordinates;
use Keet\Country\Fieldset\CoordinatesFieldset;
use Keet\Form\Factory\AbstractDoctrineFieldsetFactory;

class CoordinatesFieldsetFactory extends AbstractDoctrineFieldsetFactory
{
    public function __construct()
    {
        parent::__construct(CoordinatesFieldset::class, 'coordinates', Coordinates::class);
    }
}