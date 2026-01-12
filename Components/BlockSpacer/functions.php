<?php

namespace Flynt\Components\BlockSpacer;

use Flynt\FieldVariables;

function getACFLayout(): array
{
    return [
        'name' => 'blockSpacer',
        'label' => __('Block: Spacer', 'flynt'),
        'sub_fields' => [
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
                        'label' => __('Vertical space', 'flynt'),
                        'instructions' => __('Distance between two components.', 'flynt'),
                        'name' => 'percentageDistance',
                        'type' => 'select',
                        'choices' => [
                            '0' => 'None',
                            '30px' => 'X-Small',
                            '5vw' => 'Small',
                            '8vw' => 'Medium',
                            '10vw' => 'Large',
                        ],
                        'default_value' => 0,
                        'return_format' => 'value',
                    ],
                    // [
                    //     'label' => __('Vertical space', 'flynt'),
                    //     'instructions' => __('Distance between two components.', 'flynt'),
                    //     'name' => 'percentageDistance',
                    //     'type' => 'range',
                    //     'prepend' => __('Distance', 'flynt'),
                    //     'append' => __('%', 'flynt'),
                    //     'default_value' => 0,
                    //     'min' => 0,
                    //     'max' => 100,
                    //     'step' => 20,
                    //     'wrapper' =>  [
                    //         'width' => '100',
                    //     ],
                    // ],
                ]
            ]
        ]
    ];
}
