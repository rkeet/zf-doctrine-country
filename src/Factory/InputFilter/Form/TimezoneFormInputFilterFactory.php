<?php

namespace Keet\Country\Factory\InputFilter\Form;

use Interop\Container\ContainerInterface;
use Keet\Country\InputFilter\Fieldset\TimezoneFieldsetInputFilter;
use Keet\Country\InputFilter\Form\TimezoneFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormInputFilterFactory;

class TimezoneFormInputFilterFactory extends AbstractDoctrineFormInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return TimezoneFormInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container);

        /** @var TimezoneFieldsetInputFilter $fieldsetInputFilter */
        $fieldsetInputFilter = $this->getInputFilterManager()->get(TimezoneFieldsetInputFilter::class);

        $inputFilter = new TimezoneFormInputFilter(
            $this->getObjectManager(),
            $this->getTranslator(),
            $fieldsetInputFilter
        );

        return $inputFilter;
    }
}