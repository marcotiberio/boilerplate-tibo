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
                'label' => __('Top Text', 'flynt'),
                'name' => 'blockTextTop',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Bottom Text', 'flynt'),
                'name' => 'blockTextBottom',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Background Image', 'flynt'),
                'name' => 'backgroundImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            // [
            //     'label' => __('Content', 'flynt'),
            //     'name' => 'contentHtml',
            //     'type' => 'wysiwyg',
            //     'tabs' => 'visual',
            //     'delay' => 1,
            //     'media_upload' => 0,
            //     'required' => 0,
            // ],
            // [
            //     'label' => __('Button', 'flynt'),
            //     'name' => 'buttonLink',
            //     'type' => 'link',
            //     'required' => 0,
            //     'wrapper' => [
            //         'width' => 100
            //     ],
            // ],
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
