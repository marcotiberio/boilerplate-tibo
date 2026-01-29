<?php

namespace Flynt\Components\HeroHeader;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Flynt\Shortcodes;
use Flynt\ComponentManager;
use Timber\Timber;

function getACFLayout()
{
    return [
        'name' => 'HeroHeader',
        'label' => __('Hero Header', 'flynt'),
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
                'name' => 'blockTitle',
                'type' => 'text'
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
            ],
            [
                'label' => __('Images', 'flynt'),
                'name' => 'images',
                'type' => 'gallery',
                'required' => 0,
            ],
            [
                'label' => __('Illustrations', 'flynt'),
                'name' => 'rows',
                'type' => 'repeater',
                'layout' => 'table',
                'min' => 1,
                'button_label' => __('Add Illustration', 'flynt'),
                'sub_fields' => [
                    // FieldVariables\getColorBackground(),
                    // FieldVariables\getColorText(),
                    [
                        'label' => __('Illustration', 'flynt'),
                        'name' => 'illustration',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                        'required' => 0,
                        'mime_types' => 'jpg,jpeg,png,svg',
                        'wrapper' => [
                            'width' => 100
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Button', 'flynt'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
                'wrapper' => [
                    'width' => 100
                ],
            ],
            // [
            //     'label' => __('Image', 'flynt'),
            //     'name' => 'imageTab',
            //     'type' => 'tab',
            //     'placement' => 'top',
            //     'endpoint' => 0,
            // ],
            // [
            //     'label' => __('Background Image', 'flynt'),
            //     'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
            //     'name' => 'backgroundImage',
            //     'type' => 'image',
            //     'preview_size' => 'medium',
            //     'required' => 0,
            //     'mime_types' => 'jpg,jpeg,png,svg,webp',
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
