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
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Title Size', 'flynt'),
                'instructions' => __('Visual size of the headline.', 'flynt'),
                'name' => 'titleSize',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Title Tag', 'flynt'),
                'instructions' => __('HTML tag used for the headline (accessibility / SEO).', 'flynt'),
                'name' => 'titleTag',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Label Size', 'flynt'),
                'instructions' => __('Visual size applied to every stat label.', 'flynt'),
                'name' => 'labelSize',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 100],
            ],
            [
                'label' => __('Stats', 'flynt'),
                'name' => 'stats',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'max' => 4,
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
                    // [
                    //     'label' => __('Value', 'flynt'),
                    //     'instructions' => __('e.g. "600 Tsd."', 'flynt'),
                    //     'name' => 'value',
                    //     'type' => 'text',
                    //     'wrapper' => [
                    //         'width' => 33
                    //     ],
                    // ],
                    [
                        'label' => __('Label', 'flynt'),
                        'name' => 'label',
                        'type' => 'textarea',
                        'rows' => 2,
                        'wrapper' => [
                            'width' => 33
                        ],
                    ],
                    [
                        'label' => __('Text', 'flynt'),
                        'instructions' => __('Optional longer description shown below the label.', 'flynt'),
                        'name' => 'text',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'media_upload' => 0,
                        'delay' => 1,
                        'required' => 0,
                    ],
                    [
                        'label' => __('Button', 'flynt'),
                        'instructions' => __('Optional link shown below the label.', 'flynt'),
                        'name' => 'button',
                        'type' => 'link',
                        'required' => 0,
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
