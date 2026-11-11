<?php

namespace Flynt\Components\SliderBoxText;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SliderBoxText', function ($data) {
    $translatableOptions = Options::getTranslatable('SliderOptions');
    $data['jsonData'] = [
        'options' => array_merge($translatableOptions ?: [], $data['options'] ?? []),
    ];
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'SliderBoxText',
        'label' => __('Carousel: Testimonials', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Testimonials', 'flynt'),
                'name' => 'boxes',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Testimonial', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Quote', 'flynt'),
                        'instructions' => __('Without quotation marks; they are added automatically.', 'flynt'),
                        'name' => 'quote',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => 1,
                    ],
                    [
                        'label' => __('Attribution', 'flynt'),
                        'instructions' => __('e.g. "Name, Leiterin Wirtschaftsförderung, Stadt"', 'flynt'),
                        'name' => 'attribution',
                        'type' => 'text',
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getSectionTheme(),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
