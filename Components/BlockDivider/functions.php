<?php

namespace Flynt\Components\BlockDivider;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockDivider',
        'label' => __('Block: Divider', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Divider', 'flynt'),
                'name' => '',
                'type' => 'message',
                'message' => 'Add this component to display an horizontal black line as a divider between sections.',
                'new_lines' => 'wpautop',
                'esc_html' => 1,
                'wrapper' =>  [
                    'width' => '100',
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
