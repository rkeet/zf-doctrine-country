<?php

namespace Keet\Country\Factory\InputFilter\Fieldset;

use Interop\Container\ContainerInterface;
use Keet\Country\Entity\Language;
use Keet\Country\InputFilter\Fieldset\LanguageFieldsetInputFilter;
use Keet\Form\Factory\AbstractDoctrineFieldsetInputFilterFactory;

class LanguageFieldsetInputFilterFactory extends AbstractDoctrineFieldsetInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return LanguageFieldsetInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container, Language::class);

        return new LanguageFieldsetInputFilter(
            [
                'object_manager'    => $this->getObjectManager(),
                'object_repository' => $this->getObjectManager()->getRepository(Language::class),
                'translator'        => $this->getTranslator(),
            ]
        );
    }
}