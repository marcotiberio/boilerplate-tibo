<?php

namespace Flynt\Components\BlockBoxes;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockBoxes',
        'label' => __('Block: Boxes', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Block Title', 'flynt'),
                'name' => 'blockTitle',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Boxes', 'flynt'),
                'name' => 'boxes',
                'type' => 'repeater',
                'layout' => 'table',
                'min' => 1,
                'max' => 12,
                'button_label' => __('Add Box', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'required' => 1,
                        'mime_types' => 'jpg,jpeg,png,svg',
                        'wrapper' => [
                            'width' => 40
                        ],
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 30
                        ],
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'link',
                        'type' => 'url',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 30
                        ],
                    ],
                    FieldVariables\getColorBackground(),
                ]
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
                    [
                        'label' => __('Columns', 'flynt'),
                        'name' => 'columns',
                        'type' => 'button_group',
                        'choices' => [
                            '2' => __('2 Columns', 'flynt'),
                            '3' => __('3 Columns', 'flynt'),
                            '4' => __('4 Columns', 'flynt'),
                        ],
                        'default_value' => '3',
                        'wrapper' => [
                            'width' => 50
                        ],
                    ],
                    [
                        'label' => __('Top Border', 'flynt'),
                        'name' => 'topBorder',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                    ],
                ]
            ]
        ]
    ];
}
