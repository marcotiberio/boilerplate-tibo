<?php

namespace Flynt\Components\BlockTiles;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockTiles',
        'label' => __('Block: Tiles', 'flynt'),
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
                'label' => __('Tiles', 'flynt'),
                'name' => 'tiles',
                'type' => 'repeater',
                'layout' => 'table',
                'min' => 1,
                'max' => 12,
                'button_label' => __('Add Tile', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Content', 'flynt'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'delay' => 1,
                        'media_upload' => 0,
                        'required' => 1,
                        'wrapper' => [
                            'width' => 100
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
                ]
            ]
        ]
    ];
}
