<?php

namespace Keet\Country\InputFilter\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\InputFilter\Fieldset\CountryFieldsetInputFilter;
use Keet\Form\InputFilter\AbstractDoctrineFormInputFilter;
use Zend\Mvc\I18n\Translator;

class CountryFormInputFilter extends AbstractDoctrineFormInputFilter
{
    /**
     * @var CountryFieldsetInputFilter
     */
    protected $countryFieldsetInputFilter;

    public function __construct(
        ObjectManager $objectManager,
        Translator $translator,
        CountryFieldsetInputFilter $filter
    ) {
        $this->countryFieldsetInputFilter = $filter;

        parent::__construct(
            [
                'object_manager' => $objectManager,
                'translator'     => $translator,
            ]
        );
    }

    public function init()
    {
        $this->add($this->countryFieldsetInputFilter, 'country');

        parent::init();
    }
}