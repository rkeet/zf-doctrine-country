<?php

namespace Keet\Country\Factory\Service;

use Interop\Container\ContainerInterface;
use Keet\Country\Service\LocaleOptionsManager;
use Zend\Cache\Storage\StorageInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LocaleOptionsManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        /** @var StorageInterface $cache */
        $cache = $container->get('FilesystemCache');

        if (
            array_key_exists('translator', $config)
            && array_key_exists('translation_file_patterns', $config['translator'])
            && count($config['translator']['translation_file_patterns']) > 0
        ) {
            return new LocaleOptionsManager($cache, $config['translator']['translation_file_patterns']);
        }

        return new LocaleOptionsManager($cache, []);
    }
}