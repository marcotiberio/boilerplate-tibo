<?php

namespace Flynt\Components\BlockButtons;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockButtons',
        'label' => __('Buttons', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Buttons', 'flynt'),
                'name' => 'buttonsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Buttons', 'flynt'),
                'name' => 'buttons',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'max' => 4,
                'button_label' => __('Add Button', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Button', 'flynt'),
                        'name' => 'buttonLink',
                        'type' => 'link',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 100
                        ],
                    ],
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
                    FieldVariables\getColorBackground(),
                    [
                        'label' => __('Fixed Position?', 'flynt'),
                        'name' => 'fixed',
                        'instructions' => __('If enabled, the buttons will be fixed to the bottom of the screen.', 'flynt'),
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'wrapper' => [
                            'width' => 100
                        ],
                    ],
                ]
            ]
        ]
    ];
} 