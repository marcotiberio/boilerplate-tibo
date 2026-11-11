<?php

namespace Flynt\Components\BlockKeyFigures;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockKeyFigures',
        'label' => __('Block: Key Figures', 'flynt'),
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
            ],
            [
                'label' => __('Figures', 'flynt'),
                'name' => 'figures',
                'type' => 'repeater',
                'layout' => 'table',
                'min' => 1,
                'max' => 4,
                'button_label' => __('Add Figure', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Value', 'flynt'),
                        'instructions' => __('e.g. 120 or 35+', 'flynt'),
                        'name' => 'value',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => [
                            'width' => 30,
                        ],
                    ],
                    [
                        'label' => __('Label', 'flynt'),
                        'name' => 'label',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => [
                            'width' => 70,
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
                    FieldVariables\getSectionTheme('sage'),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
