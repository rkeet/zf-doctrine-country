<?php

namespace Keet\Country\InputFilter\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\InputFilter\Fieldset\LanguageFieldsetInputFilter;
use Keet\Form\InputFilter\AbstractDoctrineFormInputFilter;
use Zend\Mvc\I18n\Translator;

class LanguageFormInputFilter extends AbstractDoctrineFormInputFilter
{
    /**
     * @var LanguageFieldsetInputFilter
     */
    protected $languageFieldsetInputFilter;

    public function __construct(
        ObjectManager $objectManager,
        Translator $translator,
        LanguageFieldsetInputFilter $filter
    ) {
        $this->languageFieldsetInputFilter = $filter;

        parent::__construct(
            [
                'object_manager' => $objectManager,
                'translator'     => $translator,
            ]
        );
    }

    public function init()
    {
        $this->add($this->languageFieldsetInputFilter, 'language');

        parent::init();
    }
}