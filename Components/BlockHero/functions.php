<?php

namespace Flynt\Components\BlockHero;

function getACFLayout()
{
    return [
        'name' => 'BlockHero',
        'label' => __('Block: Hero', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Image', 'flynt'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            [
                'label' => __('Image (Mobile)', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                'name' => 'imageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            [
                'label' => __('Background Video', 'flynt'),
                'instructions' => __('Optional. MP4/WebM. Plays muted and looped behind the hero; the image above is used as poster/fallback. A play/pause control is shown when a video is set.', 'flynt'),
                'name' => 'video',
                'type' => 'file',
                'return_format' => 'array',
                'required' => 0,
                'mime_types' => 'mp4,webm',
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Title Size', 'flynt'),
                'instructions' => __('Visual size of the headline.', 'flynt'),
                'name' => 'titleSize',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h1',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Title Tag', 'flynt'),
                'instructions' => __('HTML tag used for the headline (accessibility / SEO).', 'flynt'),
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
                'default_value' => 'h1',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Primary Button', 'flynt'),
                'name' => 'primaryButton',
                'type' => 'link',
                'required' => 0,
            ],
            [
                'label' => __('Secondary Button', 'flynt'),
                'name' => 'secondaryButton',
                'type' => 'link',
                'required' => 0,
            ],
        ]
    ];
}
