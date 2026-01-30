<?php

namespace Flynt\Components\BlockStats;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockStats',
        'label' => __('Stats', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Stats', 'flynt'),
                'name' => 'stats',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Stat', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Number/Stat', 'flynt'),
                        'name' => 'stat',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 20
                        ],
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 40
                        ],
                    ],
                    [
                        'label' => __('Description', 'flynt'),
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'wrapper' => [
                            'width' => 40
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
                    FieldVariables\getColorText(),
                ]
            ]
        ]
    ];
}
