<?php

namespace Keet\Country;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Keet\Country\Factory\Fieldset\CoordinatesFieldsetFactory;
use Keet\Country\Factory\Fieldset\CountryFieldsetFactory;
use Keet\Country\Factory\Fieldset\CurrencyFieldsetFactory;
use Keet\Country\Factory\Fieldset\LanguageFieldsetFactory;
use Keet\Country\Factory\Fieldset\TimezoneFieldsetFactory;
use Keet\Country\Factory\Form\CoordinatesFormFactory;
use Keet\Country\Factory\Form\CountryFormFactory;
use Keet\Country\Factory\Form\CurrencyFormFactory;
use Keet\Country\Factory\Form\LanguageFormFactory;
use Keet\Country\Factory\Form\TimezoneFormFactory;
use Keet\Country\Factory\InputFilter\Fieldset\CoordinatesFieldsetInputFilterFactory;
use Keet\Country\Factory\InputFilter\Fieldset\CountryFieldsetInputFilterFactory;
use Keet\Country\Factory\InputFilter\Fieldset\CurrencyFieldsetInputFilterFactory;
use Keet\Country\Factory\InputFilter\Fieldset\LanguageFieldsetInputFilterFactory;
use Keet\Country\Factory\InputFilter\Fieldset\TimezoneFieldsetInputFilterFactory;
use Keet\Country\Factory\InputFilter\Form\CoordinatesFormInputFilterFactory;
use Keet\Country\Factory\InputFilter\Form\CountryFormInputFilterFactory;
use Keet\Country\Factory\InputFilter\Form\CurrencyFormInputFilterFactory;
use Keet\Country\Factory\InputFilter\Form\LanguageFormInputFilterFactory;
use Keet\Country\Factory\InputFilter\Form\TimezoneFormInputFilterFactory;
use Keet\Country\Factory\Service\LocaleOptionsManagerFactory;
use Keet\Country\Fieldset\CoordinatesFieldset;
use Keet\Country\Fieldset\CountryFieldset;
use Keet\Country\Fieldset\CurrencyFieldset;
use Keet\Country\Fieldset\LanguageFieldset;
use Keet\Country\Fieldset\TimezoneFieldset;
use Keet\Country\Form\CoordinatesForm;
use Keet\Country\Form\CountryForm;
use Keet\Country\Form\CurrencyForm;
use Keet\Country\Form\LanguageForm;
use Keet\Country\Form\TimezoneForm;
use Keet\Country\InputFilter\Fieldset\CoordinatesFieldsetInputFilter;
use Keet\Country\InputFilter\Fieldset\CountryFieldsetInputFilter;
use Keet\Country\InputFilter\Fieldset\CurrencyFieldsetInputFilter;
use Keet\Country\InputFilter\Fieldset\LanguageFieldsetInputFilter;
use Keet\Country\InputFilter\Fieldset\TimezoneFieldsetInputFilter;
use Keet\Country\InputFilter\Form\CoordinatesFormInputFilter;
use Keet\Country\InputFilter\Form\CountryFormInputFilter;
use Keet\Country\InputFilter\Form\CurrencyFormInputFilter;
use Keet\Country\InputFilter\Form\LanguageFormInputFilter;
use Keet\Country\InputFilter\Form\TimezoneFormInputFilter;
use Keet\Country\Service\LocaleOptionsManager;

return [
    'doctrine'      => [
        'driver'  => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__
                    . DIRECTORY_SEPARATOR . '..'
                    . DIRECTORY_SEPARATOR . 'src'
                    . DIRECTORY_SEPARATOR . 'Entity',
                ],
            ],
            'orm_default'             => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
        'fixture' => [
            __NAMESPACE__ . '_fixture' => __DIR__
                . DIRECTORY_SEPARATOR . '..'
                . DIRECTORY_SEPARATOR . 'src'
                . DIRECTORY_SEPARATOR . 'Fixture',
        ],
    ],
    'form_elements' => [
        'factories' => [
            CountryForm::class         => CountryFormFactory::class,
            CountryFieldset::class     => CountryFieldsetFactory::class,
            CoordinatesFieldset::class => CoordinatesFieldsetFactory::class,
            CoordinatesForm::class     => CoordinatesFormFactory::class,
            CurrencyFieldset::class    => CurrencyFieldsetFactory::class,
            CurrencyForm::class        => CurrencyFormFactory::class,
            LanguageFieldset::class    => LanguageFieldsetFactory::class,
            LanguageForm::class        => LanguageFormFactory::class,
            TimezoneFieldset::class    => TimezoneFieldsetFactory::class,
            TimezoneForm::class        => TimezoneFormFactory::class,
        ],
    ],
    'input_filters' => [
        'factories' => [
            CountryFormInputFilter::class         => CountryFormInputFilterFactory::class,
            CountryFieldsetInputFilter::class     => CountryFieldsetInputFilterFactory::class,
            CoordinatesFormInputFilter::class     => CoordinatesFormInputFilterFactory::class,
            CoordinatesFieldsetInputFilter::class => CoordinatesFieldsetInputFilterFactory::class,
            CurrencyFormInputFilter::class        => CurrencyFormInputFilterFactory::class,
            CurrencyFieldsetInputFilter::class    => CurrencyFieldsetInputFilterFactory::class,
            LanguageFormInputFilter::class        => LanguageFormInputFilterFactory::class,
            LanguageFieldsetInputFilter::class    => LanguageFieldsetInputFilterFactory::class,
            TimezoneFormInputFilter::class        => TimezoneFormInputFilterFactory::class,
            TimezoneFieldsetInputFilter::class    => TimezoneFieldsetInputFilterFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            LocaleOptionsManager::class  => LocaleOptionsManagerFactory::class,
        ],
    ],
];