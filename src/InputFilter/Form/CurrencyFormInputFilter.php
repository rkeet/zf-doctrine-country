<?php

namespace Keet\Country\InputFilter\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Keet\Country\InputFilter\Fieldset\CurrencyFieldsetInputFilter;
use Keet\Form\InputFilter\AbstractDoctrineFormInputFilter;
use Zend\Mvc\I18n\Translator;

class CurrencyFormInputFilter extends AbstractDoctrineFormInputFilter
{
    /**
     * @var CurrencyFieldsetInputFilter
     */
    protected $currencyFieldsetInputFilter;

    public function __construct(
        ObjectManager $objectManager,
        Translator $translator,
        CurrencyFieldsetInputFilter $filter
    ) {
        $this->currencyFieldsetInputFilter = $filter;

        parent::__construct(
            [
                'object_manager' => $objectManager,
                'translator'     => $translator,
            ]
        );
    }

    public function init()
    {
        $this->add($this->currencyFieldsetInputFilter, 'currency');

        parent::init();
    }
}