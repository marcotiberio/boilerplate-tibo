<?php

namespace Flynt\Components\BlockSliderLogos;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=BlockSliderLogos', function ($data) {
    $translatableOptions = Options::getTranslatable('SliderOptions');
    $data['jsonData'] = [
        'options' => array_merge($translatableOptions, $data['options']),
    ];
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'BlockSliderLogos',
        'label' => 'Carousel: Logos',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'blockTitle',
                'type' => 'text',
            ],
            [
                'label' => __('Logo Selection', 'flynt'),
                'name' => 'logoSelectionTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Text Boxes', 'flynt'),
                'name' => 'contentBoxes',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Box', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Logo/Icon', 'flynt'),
                        'name' => 'panelLogo',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'instructions' => __('Accepted Image-Formats: SVG, PNG. Recommended Image-Format: SVG.', 'flynt'),
                        'required' => 0,
                        'mime_types' => 'png,svg,jpg, jpeg',
                        'wrapper' => [
                            'width' => 50
                        ],
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'panelLink',
                        'type' => 'link',
                        'return_format' => 'array',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 50
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getColorBackground(),
                ]
            ]
        ]
    ];
}

Options::addTranslatable('BlockSliderLogos', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('"View All" Button', 'flynt'),
                'name' => 'viewAll',
                'type' => 'text',
                'default_value' => __('View All', 'flynt'),
                'required' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
        ],
    ]
]);
