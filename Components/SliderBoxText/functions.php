<?php

namespace Flynt\Components\SliderBoxText;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'SliderBoxText',
        'label' => 'Carousel: Text',
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
                'type' => 'text'
            ],
            [
                'label' => __('Boxes', 'flynt'),
                'name' => 'boxes',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'button_label' => __('Add Step', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                    ],
                    [
                        'label' => __('Artist', 'flynt'),
                        'name' => 'artist',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 50
                        ]
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                         'wrapper' => [
                            'width' => 50
                        ]
                    ],
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'textarea',
                    ],
                    [
                        'label' => __('Button', 'flynt'),
                        'name' => 'buttonLink',
                        'type' => 'link',
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
                    FieldVariables\getColorText(),
                ]
            ]
        ]
    ];
}
