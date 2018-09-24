<?php

namespace Keet\Country\Factory\InputFilter\Fieldset;

use Interop\Container\ContainerInterface;
use Keet\Country\Entity\Timezone;
use Keet\Country\InputFilter\Fieldset\TimezoneFieldsetInputFilter;
use Keet\Form\Factory\AbstractDoctrineFieldsetInputFilterFactory;

class TimezoneFieldsetInputFilterFactory extends AbstractDoctrineFieldsetInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return TimezoneFieldsetInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container, Timezone::class);

        return new TimezoneFieldsetInputFilter(
            [
                'object_manager'    => $this->getObjectManager(),
                'object_repository' => $this->getObjectManager()->getRepository(Timezone::class),
                'translator'        => $this->getTranslator(),
            ]
        );
    }
}