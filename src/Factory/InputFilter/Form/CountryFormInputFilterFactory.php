<?php

namespace Keet\Country\Factory\InputFilter\Form;

use Interop\Container\ContainerInterface;
use Keet\Country\InputFilter\Fieldset\CountryFieldsetInputFilter;
use Keet\Country\InputFilter\Form\CountryFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormInputFilterFactory;

class CountryFormInputFilterFactory extends AbstractDoctrineFormInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CountryFormInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container);

        /** @var CountryFieldsetInputFilter $fieldsetInputFilter */
        $fieldsetInputFilter = $this->getInputFilterManager()->get(CountryFieldsetInputFilter::class);

        $inputFilter = new CountryFormInputFilter(
            $this->getObjectManager(),
            $this->getTranslator(),
            $fieldsetInputFilter
        );

        return $inputFilter;
    }
}