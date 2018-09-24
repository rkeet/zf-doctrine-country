<?php

namespace Keet\Country\InputFilter\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\InputFilter\Fieldset\TimezoneFieldsetInputFilter;
use Keet\Form\InputFilter\AbstractDoctrineFormInputFilter;
use Zend\Mvc\I18n\Translator;

class TimezoneFormInputFilter extends AbstractDoctrineFormInputFilter
{
    /**
     * @var TimezoneFieldsetInputFilter
     */
    protected $timezoneFieldsetInputFilter;

    public function __construct(
        ObjectManager $objectManager,
        Translator $translator,
        TimezoneFieldsetInputFilter $filter
    ) {
        $this->timezoneFieldsetInputFilter = $filter;

        parent::__construct(
            [
                'object_manager' => $objectManager,
                'translator'     => $translator,
            ]
        );
    }

    public function init()
    {
        $this->add($this->timezoneFieldsetInputFilter, 'timezone');

        parent::init();
    }
}