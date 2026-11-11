<?php

namespace Flynt\Components\GridSteps;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'GridSteps',
        'label' => __('Grid: Steps', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            FieldVariables\getLabel(),
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Description', 'flynt'),
                'name' => 'description',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Steps', 'flynt'),
                'name' => 'stepsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Steps', 'flynt'),
                'instructions' => __('Numbered automatically in this order.', 'flynt'),
                'name' => 'steps',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Step', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                        'new_lines' => 'br',
                    ],
                ],
            ],
            [
                'label' => __('Footer', 'flynt'),
                'name' => 'footerTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            FieldVariables\getButtons(1),
            [
                'label' => __('Footnote', 'flynt'),
                'instructions' => __('Small line under the steps, e.g. "Dauer · Teilnehmende · Ort".', 'flynt'),
                'name' => 'footnote',
                'type' => 'text',
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
                        'label' => __('Layout', 'flynt'),
                        'name' => 'layout',
                        'type' => 'button_group',
                        'choices' => [
                            'cards' => __('Cards (2 × 2)', 'flynt'),
                            'list' => __('List', 'flynt'),
                        ],
                        'default_value' => 'cards',
                    ],
                    FieldVariables\getSectionTheme('sage'),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
