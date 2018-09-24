<?php

namespace Keet\Country\InputFilter\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\InputFilter\Fieldset\CoordinatesFieldsetInputFilter;
use Keet\Form\InputFilter\AbstractDoctrineFormInputFilter;
use Zend\Mvc\I18n\Translator;

class CoordinatesFormInputFilter extends AbstractDoctrineFormInputFilter
{
    /**
     * @var CoordinatesFieldsetInputFilter
     */
    protected $coordinatesFieldsetInputFilter;

    public function __construct(
        ObjectManager $objectManager,
        Translator $translator,
        CoordinatesFieldsetInputFilter $filter
    ) {
        $this->coordinatesFieldsetInputFilter = $filter;

        parent::__construct(
            [
                'object_manager' => $objectManager,
                'translator'     => $translator,
            ]
        );
    }

    public function init()
    {
        $this->add($this->coordinatesFieldsetInputFilter, 'coordinates');

        parent::init();
    }
}