<?php

namespace Flynt\Components\BlockStats;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockStats',
        'label' => __('Block: Stats', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Stats', 'flynt'),
                'name' => 'stats',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'button_label' => __('Add Stat', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Icon', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                        'name' => 'icon',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'required' => 0,
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'wrapper' => [
                            'width' => 34
                        ],
                    ],
                    [
                        'label' => __('Value', 'flynt'),
                        'instructions' => __('e.g. "600 Tsd."', 'flynt'),
                        'name' => 'value',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 33
                        ],
                    ],
                    [
                        'label' => __('Label', 'flynt'),
                        'name' => 'label',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => [
                            'width' => 33
                        ],
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
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                ]
            ]
        ]
    ];
}
