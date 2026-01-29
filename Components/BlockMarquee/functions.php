<?php

namespace Flynt\Components\BlockMarquee;

function getACFLayout()
{
    return [
        'name' => 'BlockMarquee',
        'label' => __('Block: Marquee', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Marquee Rows', 'flynt'),
                'name' => 'marqueeRows',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'max' => 7,
                'button_label' => __('Add Row', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'label' => __('Speed', 'flynt'),
                        'name' => 'speed',
                        'type' => 'select',
                        'choices' => [
                            'slow' => __('Slow (60s)', 'flynt'),
                            'normal' => __('Normal (30s)', 'flynt'),
                            'fast' => __('Fast (15s)', 'flynt'),
                            'very-fast' => __('Very Fast (10s)', 'flynt'),
                        ],
                        'default_value' => 'normal',
                        'return_format' => 'value',
                    ],
                    [
                        'label' => __('Direction', 'flynt'),
                        'name' => 'direction',
                        'type' => 'select',
                        'choices' => [
                            'left' => __('Left', 'flynt'),
                            'right' => __('Right', 'flynt'),
                        ],
                        'default_value' => 'left',
                        'return_format' => 'value',
                    ],
                ],
            ],
        ],
    ];
}
