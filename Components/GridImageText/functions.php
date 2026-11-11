<?php

namespace Flynt\Components\GridImageText;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'GridImageText',
        'label' => __('Grid: Image Text', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'headlineTitle',
                'type' => 'text',
            ],
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'intro',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Items', 'flynt'),
                'name' => 'itemsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Items', 'flynt'),
                'name' => 'items',
                'type' => 'repeater',
                'collapsed' => '',
                'layout' => 'block',
                'button_label' => __('Add Item', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'instructions' => __('Optional. Image-Format: JPG, PNG, WEBP, SVG.', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'wrapper' => [
                            'width' => 30,
                        ],
                    ],
                    [
                        'label' => __('Label', 'flynt'),
                        'instructions' => __('Optional tag, e.g. "Im Umbau".', 'flynt'),
                        'name' => 'label',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 30,
                        ],
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 40,
                        ],
                    ],
                    [
                        'label' => __('Content', 'flynt'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 1,
                    ],
                    [
                        'label' => __('Footnote', 'flynt'),
                        'instructions' => __('Optional small line, e.g. "Auftrag: Bildung".', 'flynt'),
                        'name' => 'footnote',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'itemLink',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' => [
                            'width' => 50,
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
                        'label' => __('Look', 'flynt'),
                        'name' => 'look',
                        'type' => 'button_group',
                        'choices' => [
                            'columns' => __('Columns with top rule', 'flynt'),
                            'cards' => __('Dark cards', 'flynt'),
                        ],
                        'default_value' => 'columns',
                    ],
                    [
                        'label' => __('Grid Columns', 'flynt'),
                        'name' => 'gridColumns',
                        'type' => 'button_group',
                        'choices' => [
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ],
                        'default_value' => '4',
                    ],
                    FieldVariables\getSectionTheme(),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
