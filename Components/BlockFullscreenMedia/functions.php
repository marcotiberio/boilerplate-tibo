<?php

namespace Flynt\Components\BlockFullscreenMedia;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockFullscreenMedia',
        'label' => __('Block: Fullscreen Media', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Media', 'flynt'),
                'name' => 'mediaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image Desktop', 'flynt'),
                'instructions' => __('Full-bleed background. JPG, PNG, WEBP.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Image Mobile', 'flynt'),
                'name' => 'imageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Height', 'flynt'),
                'name' => 'height',
                'type' => 'select',
                'default_value' => 'min-h-[70vh]',
                'choices' => [
                    'min-h-[70vh]' => __('2/3 Screen', 'flynt'),
                    'min-h-screen' => __('Full Screen', 'flynt'),
                ],
                'wrapper' => ['width' => 100],
            ],
            [
                'label' => __('Overlay quote', 'flynt'),
                'name' => 'quoteTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Quote', 'flynt'),
                'name' => 'quoteHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'required' => 0,
            ],
            [
                'label' => __('Attribution', 'flynt'),
                'name' => 'attribution',
                'type' => 'text',
                'required' => 0,
            ],
        ],
    ];
}
