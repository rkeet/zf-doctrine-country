<?php

namespace Keet\Country\Service;

use Zend\Cache\Storage\StorageInterface;

class LocaleOptionsManager
{
    /**
     * @var StorageInterface
     */
    protected $cache;

    /**
     * @var array
     */
    protected $config;

    public function __construct(StorageInterface $cache, array $config)
    {
        $this->setCache($cache);
        $this->setConfig($config);
    }

    /**
     * @param bool $forceCreate
     *
     * @return array
     */
    public function __invoke(bool $forceCreate = false) : array
    {
        if ($forceCreate) {
            // Must recreate cache - remove current locale options
            $this->getCache()->removeItem('locale_options');
        }

        // Loads locale options from cache into $cache. Result (bool) of whether action succeeded loaded into $result
        $cache = $this->getCache()->getItem('locale_options', $result);

        if ($result) {
            // Loading cache (above) succeeded, return cache contents
            return $cache;
        }

        // Above loading of cache didn't succeed or didn't exist, create new cache

        $options = [];
        foreach ($this->getConfig() as $config) {
            if (
                array_key_exists('base_dir', $config)
                && isset($config['base_dir'])
                && array_key_exists('pattern', $config)
                && isset($config['pattern'])
            ) {
                // str_replace used to replace "%s" with "*" to make it a regex pattern accepted by glob()
                foreach (
                    glob(
                        str_replace('%s', '*', $config['base_dir'] . DIRECTORY_SEPARATOR . $config['pattern'])
                    ) as $fileName
                ) {
                    // Specifically returns filename without extension - see: http://php.net/manual/en/function.pathinfo.php
                    $options[] = pathinfo($fileName, PATHINFO_FILENAME);
                }
            }
        }

        // Save supported locales to cache
        if ($this->getCache()->setItem('locale_options', $options)) {

            return $options;
        }

        return [];
    }

    /**
     * @return StorageInterface
     */
    public function getCache() : StorageInterface
    {
        return $this->cache;
    }

    /**
     * @param StorageInterface $cache
     *
     * @return LocaleOptionsManager
     */
    public function setCache(StorageInterface $cache) : LocaleOptionsManager
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig() : array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config) : void
    {
        $this->config = $config;
    }

}