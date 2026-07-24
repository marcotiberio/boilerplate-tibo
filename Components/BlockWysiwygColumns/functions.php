<?php

namespace Flynt\Components\BlockWysiwygColumns;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockWysiwygColumns',
        'label' => __('Text Editor (Columns)', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Columns', 'flynt'),
                'name' => 'columns',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'max' => 3,
                'button_label' => __('Add Column', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Width', 'flynt'),
                        'instructions' => __('Column width. Inherit follows the Columns option in the Options tab.', 'flynt'),
                        'name' => 'width',
                        'type' => 'select',
                        'choices' => [
                            'default' => __('Inherit', 'flynt'),
                            'third' => __('1/3', 'flynt'),
                            'half' => __('1/2', 'flynt'),
                            'full' => __('1/1', 'flynt'),
                        ],
                        'default_value' => 'default',
                        'allow_null' => 0,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('List Style', 'flynt'),
                        'instructions' => __('Checklist renders bullet lists with check icons.', 'flynt'),
                        'name' => 'listStyle',
                        'type' => 'select',
                        'choices' => [
                            'default' => __('Default', 'flynt'),
                            'checklist' => __('Checklist', 'flynt'),
                        ],
                        'default_value' => 'default',
                        'allow_null' => 0,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Content', 'flynt'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'delay' => 1,
                        'media_upload' => 0,
                        'required' => 0,
                        'wrapper' => [
                            'width' => 100,
                        ],
                    ],
                    [
                        'label' => __('Button', 'flynt'),
                        'name' => 'button',
                        'type' => 'link',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 100,
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
                    [
                        'label' => __('Columns', 'flynt'),
                        'instructions' => __('Number of columns shown.', 'flynt'),
                        'name' => 'columnCount',
                        'type' => 'select',
                        'choices' => [
                            '1' => __('1', 'flynt'),
                            '2' => __('2', 'flynt'),
                            '3' => __('3', 'flynt'),
                            '4' => __('4', 'flynt'),
                        ],
                        'default_value' => '2',
                        'allow_null' => 0,
                        'wrapper' => [
                            'width' => 100,
                        ],
                    ],
                ],
            ],
        ],
    ];
}
