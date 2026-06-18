<?php

namespace Flynt\Components\BlockGallery;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockGallery',
        'label' => 'Block: Gallery',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'preContent',
                'type' => 'text'
            ],
            [
                'label' => __('Images', 'flynt'),
                'name' => 'images',
                'type' => 'gallery',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
                'min' => 1,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
            ],
        ]
    ];
}
