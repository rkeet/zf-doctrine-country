<?php

namespace Keet\Country\Factory\InputFilter\Fieldset;

use Interop\Container\ContainerInterface;
use Keet\Country\Entity\Currency;
use Keet\Country\InputFilter\Fieldset\CurrencyFieldsetInputFilter;
use Keet\Form\Factory\AbstractDoctrineFieldsetInputFilterFactory;

class CurrencyFieldsetInputFilterFactory extends AbstractDoctrineFieldsetInputFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return CurrencyFieldsetInputFilter
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        parent::setupRequirements($container, Currency::class);

        return new CurrencyFieldsetInputFilter(
            [
                'object_manager'    => $this->getObjectManager(),
                'object_repository' => $this->getObjectManager()->getRepository(Currency::class),
                'translator'        => $this->getTranslator(),
            ]
        );
    }
}