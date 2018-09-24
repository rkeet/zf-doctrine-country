<?php

namespace Keet\Country\Factory\InputFilter\Fieldset;

use Interop\Container\ContainerInterface;
use Keet\Country\Entity\Country;
use Keet\Country\InputFilter\Fieldset\CoordinatesFieldsetInputFilter;
use Keet\Country\InputFilter\Fieldset\CountryFieldsetInputFilter;
use Keet\Form\Factory\AbstractDoctrineFieldsetInputFilterFactory;

class CountryFieldsetInputFilterFactory extends AbstractDoctrineFieldsetInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CountryFieldsetInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container, Country::class);

        /** @var CoordinatesFieldsetInputFilter $coordinatesFieldsetInputFilter */
        $coordinatesFieldsetInputFilter = $this->getInputFilterManager()->get(CoordinatesFieldsetInputFilter::class);
        $coordinatesFieldsetInputFilter->setRequired(false);

        return new CountryFieldsetInputFilter(
            $this->getObjectManager(),
            $this->getTranslator(),
            $coordinatesFieldsetInputFilter
        );
    }
}