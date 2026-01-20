<?php

namespace Flynt\Components\HeroMultimedia;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'HeroMultimedia',
        'label' => __('Hero (Multimedia)', 'flynt'),
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
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Image Mobile', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                'name' => 'imageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Video File', 'flynt'),
                'name' => 'videoFile',
                'type' => 'file',
                'required' => 0,
                'instructions' => __('Video-Format: MP4, MOV. Recommended: MP4 for best compatibility.', 'flynt'),
                'mime_types' => 'mp4, mov',
                'return_format' => 'array',
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Video File Mobile', 'flynt'),
                'name' => 'videoFileMobile',
                'type' => 'file',
                'required' => 0,
                'instructions' => __('Video-Format: MP4, MOV. Recommended: MP4 for best compatibility.', 'flynt'),
                'mime_types' => 'mp4, mov',
                'return_format' => 'array',
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'titleHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'default',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'width' => 100
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
        ]

    ];
}
    
