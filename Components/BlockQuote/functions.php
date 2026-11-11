<?php

namespace Flynt\Components\BlockQuote;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockQuote',
        'label' => __('Block: Quote', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Quote', 'flynt'),
                'instructions' => __('Without quotation marks; they are added automatically.', 'flynt'),
                'name' => 'quote',
                'type' => 'textarea',
                'rows' => 3,
                'required' => 1,
            ],
            [
                'label' => __('Name', 'flynt'),
                'name' => 'name',
                'type' => 'text',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Role', 'flynt'),
                'name' => 'role',
                'type' => 'text',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Organisation', 'flynt'),
                'name' => 'organisation',
                'type' => 'text',
                'wrapper' => [
                    'width' => 34,
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
                    FieldVariables\getSectionTheme('sage'),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
