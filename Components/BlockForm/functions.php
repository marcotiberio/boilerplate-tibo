<?php

namespace Flynt\Components\BlockForm;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockForm',
        'label' => __('Form', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Text position', 'flynt'),
                'name' => 'textPosition',
                'type' => 'button_group',
                'choices' => [
                    'left' => sprintf('<i class=\'dashicons dashicons-align-left\' title=\'%1$s\'></i>', __('Text on the left (half-width)', 'flynt')),
                    'center' => sprintf('<i class=\'dashicons dashicons-menu-alt3\' title=\'%1$s\'></i>', __('Text centered (full-width)', 'flynt')),
                    'right' => sprintf('<i class=\'dashicons dashicons-align-right\' title=\'%1$s\'></i>', __('Text on the right (half-width)', 'flynt'))
                ],
                'default_value' => 'center',
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 1,
            ],
            [
                'label' => __('Illustration', 'flynt'),
                'name' => 'illustration',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Shortcode', 'flynt'),
                'instructions' => __('Paste your shortcode here (e.g. [wpforms id="1587"])', 'flynt'),
                'name' => 'shortcode',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Embed Code', 'flynt'),
                'instructions' => __('Paste your embed code here (iframe, script tags, etc.)', 'flynt'),
                'name' => 'embedCode',
                'type' => 'textarea',
                'rows' => 4,
                'required' => 0,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            // [
            //     'label' => __('Button', 'flynt'),
            //     'name' => 'buttonLink',
            //     'type' => 'link',
            //     'required' => 0,
            //     'wrapper' => [
            //         'width' => 100
            //     ],
            // ],
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
