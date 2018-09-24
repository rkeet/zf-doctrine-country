<?php

namespace Keet\Country\Entity;

use Doctrine\ORM\Mapping as ORM;
use Keet\Mvc\Entity\AbstractEntity;
use Keet\Mvc\Traits\EnabledTrait;

/**
 * Class Language
 * @package Keet\Country\Entity
 *
 * @ORM\Entity(repositoryClass="Keet\Country\Repository\LanguageRepository")
 * @ORM\Table(name="country_languages")
 */
class Language extends AbstractEntity
{
    use EnabledTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="code", type="string", length=10, nullable=false)
     */
    protected $code;

    /**
     * @var string
     * @ORM\Column(name="direction", type="string", length=3, nullable=false)
     */
    protected $direction;

    /**
     * @var string
     * @ORM\Column(name="local_name", type="string", length=255, nullable=false)
     */
    protected $localName;

    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Language
     */
    public function setName(string $name) : Language
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode() : ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Language
     */
    public function setCode(string $code) : Language
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirection() : ?string
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     *
     * @return Language
     */
    public function setDirection(string $direction) : Language
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocalName() : ?string
    {
        return $this->localName;
    }

    /**
     * @param string $localName
     *
     * @return Language
     */
    public function setLocalName(string $localName) : Language
    {
        $this->localName = $localName;

        return $this;
    }

}