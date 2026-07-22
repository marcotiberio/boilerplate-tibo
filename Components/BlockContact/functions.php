<?php

namespace Flynt\Components\BlockContact;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockContact',
        'label' => __('Block: Contact', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Text', 'flynt'),
                'name' => 'textTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 1,
                'wrapper' => ['width' => 40],
            ],
            [
                'label' => __('Title Style', 'flynt'),
                'instructions' => __('Lead is the large serif heading, Label is the smaller serif intro.', 'flynt'),
                'name' => 'titleStyle',
                'type' => 'select',
                'choices' => [
                    'h3' => __('Lead', 'flynt'),
                    'h5' => __('Label', 'flynt'),
                ],
                'default_value' => 'h3',
                'allow_null' => 0,
                'wrapper' => ['width' => 30],
            ],
            [
                'label' => __('Title Tag', 'flynt'),
                'instructions' => __('HTML tag used for the title (accessibility / SEO).', 'flynt'),
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
                'wrapper' => ['width' => 30],
            ],
            [
                'label' => __('Text', 'flynt'),
                'instructions' => __('Optional body copy shown between the title and the contact card.', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
                'wrapper' => ['width' => 100],
            ],
            [
                'label' => __('Contact Person', 'flynt'),
                'name' => 'contactpersonTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Contact Person', 'flynt'),
                'name' => 'contact',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'label' => __('Photo', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'return_format' => 'array',
                        'required' => 0,
                        'mime_types' => 'jpg,jpeg,png,webp',
                        'wrapper' => ['width' => 100],
                    ],
                    [
                        'label' => __('Name', 'flynt'),
                        'name' => 'name',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Role', 'flynt'),
                        'instructions' => __('Optional job title / department.', 'flynt'),
                        'name' => 'role',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Phone', 'flynt'),
                        'name' => 'phone',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Email', 'flynt'),
                        'name' => 'email',
                        'type' => 'email',
                        'required' => 0,
                        'wrapper' => ['width' => 50],
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
                ],
            ],
        ],
    ];
}
