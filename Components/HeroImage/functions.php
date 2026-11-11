<?php

namespace Flynt\Components\HeroImage;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'HeroImage',
        'label' => __('Hero (Image)', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Image', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image Desktop', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, WEBP. Shown with a forest tint.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,webp',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Image Mobile', 'flynt'),
                'instructions' => __('Optional. Falls back to the desktop image.', 'flynt'),
                'name' => 'imageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,webp',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Height', 'flynt'),
                'name' => 'height',
                'type' => 'button_group',
                'choices' => [
                    'tall' => __('Tall (home, content pages)', 'flynt'),
                    'short' => __('Short (overview pages)', 'flynt'),
                ],
                'default_value' => 'tall',
            ],
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
                'instructions' => __('Page title (H1).', 'flynt'),
                'name' => 'title',
                'type' => 'textarea',
                'rows' => 2,
                'new_lines' => 'br',
                'required' => 1,
            ],
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'intro',
                'type' => 'textarea',
                'rows' => 3,
            ],
            FieldVariables\getButtons(2),
        ],
    ];
}
