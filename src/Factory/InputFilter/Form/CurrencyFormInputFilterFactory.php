<?php

namespace Keet\Country\Factory\InputFilter\Form;

use Interop\Container\ContainerInterface;
use Keet\Country\InputFilter\Fieldset\CurrencyFieldsetInputFilter;
use Keet\Country\InputFilter\Form\CurrencyFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormInputFilterFactory;

class CurrencyFormInputFilterFactory extends AbstractDoctrineFormInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CurrencyFormInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container);

        /** @var CurrencyFieldsetInputFilter $fieldsetInputFilter */
        $fieldsetInputFilter = $this->getInputFilterManager()->get(CurrencyFieldsetInputFilter::class);

        $inputFilter = new CurrencyFormInputFilter(
            $this->getObjectManager(),
            $this->getTranslator(),
            $fieldsetInputFilter
        );

        return $inputFilter;
    }
}