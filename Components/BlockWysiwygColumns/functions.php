<?php

namespace Flynt\Components\BlockWysiwygColumns;

use Flynt\FieldVariables;
use Flynt\Shortcodes;

function getACFLayout()
{
    return [
        'name' => 'BlockWysiwygColumns',
        'label' => __('Text Editor (Columns)', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Left Column', 'flynt'),
                'name' => 'leftColumnTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Width (%)', 'flynt'),
                'name' => 'leftColumnWidth',
                'type' => 'number',
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default_value' => 66,
                'append' => '%',
                'required' => 1,
                'wrapper' => [
                    'width' => 100
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'leftColumnContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
            ],
            [
                'label' => __('Right Column', 'flynt'),
                'name' => 'rightColumnTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Width (%)', 'flynt'),
                'name' => 'rightColumnWidth',
                'type' => 'number',
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default_value' => 33,
                'append' => '%',
                'required' => 1,
                'wrapper' => [
                    'width' => 100
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'rightColumnContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
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
                ]
            ]
        ]
    ];
} 