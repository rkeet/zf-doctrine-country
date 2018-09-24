<?php

namespace Keet\Country\Factory\InputFilter\Fieldset;

use Interop\Container\ContainerInterface;
use Keet\Country\Entity\Coordinates;
use Keet\Country\InputFilter\Fieldset\CoordinatesFieldsetInputFilter;
use Keet\Form\Factory\AbstractDoctrineFieldsetInputFilterFactory;

class CoordinatesFieldsetInputFilterFactory extends AbstractDoctrineFieldsetInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CoordinatesFieldsetInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container, Coordinates::class);

        return new CoordinatesFieldsetInputFilter(
            [
                'object_manager'    => $this->getObjectManager(),
                'object_repository' => $this->getObjectManager()->getRepository(Coordinates::class),
                'translator'        => $this->getTranslator(),
            ]
        );
    }
}