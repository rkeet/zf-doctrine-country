<?php

namespace Keet\Country\Factory\InputFilter\Form;

use Interop\Container\ContainerInterface;
use Keet\Country\InputFilter\Fieldset\LanguageFieldsetInputFilter;
use Keet\Country\InputFilter\Form\LanguageFormInputFilter;
use Keet\Form\Factory\AbstractDoctrineFormInputFilterFactory;

class LanguageFormInputFilterFactory extends AbstractDoctrineFormInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return LanguageFormInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container);

        /** @var LanguageFieldsetInputFilter $fieldsetInputFilter */
        $fieldsetInputFilter = $this->getInputFilterManager()->get(LanguageFieldsetInputFilter::class);

        $inputFilter = new LanguageFormInputFilter(
            $this->getObjectManager(),
            $this->getTranslator(),
            $fieldsetInputFilter
        );

        return $inputFilter;
    }
}