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
                        'instructions' => __('Column width. Columns flow inline and wrap based on their widths.', 'flynt'),
                        'name' => 'width',
                        'type' => 'select',
                        'choices' => [
                            'third' => __('1/3', 'flynt'),
                            'half' => __('1/2', 'flynt'),
                            'full' => __('1/1', 'flynt'),
                        ],
                        'default_value' => 'half',
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
                        'label' => __('Headline', 'flynt'),
                        'instructions' => __('Optional heading shown above the content.', 'flynt'),
                        'name' => 'headline',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Headline Size', 'flynt'),
                        'instructions' => __('Visual size of the headline.', 'flynt'),
                        'name' => 'headlineSize',
                        'type' => 'select',
                        'choices' => [
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ],
                        'default_value' => 'h3',
                        'allow_null' => 0,
                        'wrapper' => [
                            'width' => 25,
                        ],
                    ],
                    [
                        'label' => __('Headline Tag', 'flynt'),
                        'instructions' => __('HTML tag used for the headline (accessibility / SEO).', 'flynt'),
                        'name' => 'headlineTag',
                        'type' => 'select',
                        'choices' => [
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h5' => 'H5',
                            'h6' => 'H6',
                        ],
                        'default_value' => 'h3',
                        'allow_null' => 0,
                        'wrapper' => [
                            'width' => 25,
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
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Button Color', 'flynt'),
                        'instructions' => __('Colour variant of the button.', 'flynt'),
                        'name' => 'buttonStyle',
                        'type' => 'select',
                        'choices' => [
                            'primary' => __('Primary', 'flynt'),
                            'secondary' => __('Secondary', 'flynt'),
                            'accent' => __('Accent', 'flynt'),
                            'mutedWhite' => __('Muted White', 'flynt'),
                        ],
                        'default_value' => 'primary',
                        'allow_null' => 0,
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
                'sub_fields' => [],
            ],
        ],
    ];
}
