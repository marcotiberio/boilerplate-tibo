<?php

namespace Flynt\Components\BlockWysiwyg;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockWysiwyg',
        'label' => __('Text Editor', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
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
                'media_upload' => 1,
                'required' => 1,
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
