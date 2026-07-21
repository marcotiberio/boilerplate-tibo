<?php

namespace Flynt\Components\BlockIcons;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockIcons',
        'label' => __('Block: Icons', 'flynt'),
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
                'instructions' => __('Optional section heading.', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Item Title Style', 'flynt'),
                'instructions' => __('Large for stats/numbers (e.g. "600 Tsd."), Heading for word titles (e.g. "Patenschaft").', 'flynt'),
                'name' => 'titleStyle',
                'type' => 'select',
                'choices' => [
                    'h2' => __('Large (numbers)', 'flynt'),
                    'h4' => __('Heading (words)', 'flynt'),
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Items', 'flynt'),
                'name' => 'items',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Item', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Icon', 'flynt'),
                        'instructions' => __('Image-Format: SVG, PNG, JPG, WEBP.', 'flynt'),
                        'name' => 'icon',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'required' => 0,
                        'mime_types' => 'svg,png,jpg,jpeg,webp',
                        'wrapper' => [
                            'width' => 25,
                        ],
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'instructions' => __('A number (e.g. "290") or a short heading (e.g. "Rettung").', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => [
                            'width' => 75,
                        ],
                    ],
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                        'new_lines' => 'br',
                        'required' => 0,
                    ],
                    [
                        'label' => __('Button', 'flynt'),
                        'instructions' => __('Optional call to action.', 'flynt'),
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
                ],
            ],
        ],
    ];
}
