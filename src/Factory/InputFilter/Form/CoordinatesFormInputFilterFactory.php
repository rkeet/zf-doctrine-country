<?php

namespace Keet\Country\Factory\InputFilter\Form;

use Interop\Container\ContainerInterface;
use Keet\Country\InputFilter\Fieldset\CoordinatesFieldsetInputFilter;
use Keet\Country\InputFilter\Form\CoordinatesFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormInputFilterFactory;

class CoordinatesFormInputFilterFactory extends AbstractDoctrineFormInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CoordinatesFormInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container);

        /** @var CoordinatesFieldsetInputFilter $fieldsetInputFilter */
        $fieldsetInputFilter = $this->getInputFilterManager()->get(CoordinatesFieldsetInputFilter::class);

        $inputFilter = new CoordinatesFormInputFilter(
            $this->getObjectManager(),
            $this->getTranslator(),
            $fieldsetInputFilter
        );

        return $inputFilter;
    }
}