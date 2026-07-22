<?php

namespace Flynt\Components\BlockImagePost;

function getACFLayout()
{
    return [
        'name' => 'BlockImagePost',
        'label' => __('Block: Image', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('JPG, PNG, SVG, WEBP. Also used as the poster/fallback when a video is set.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 1,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Video', 'flynt'),
                'instructions' => __('Optional. MP4/WebM. Plays muted and looped; the image above is used as poster/fallback.', 'flynt'),
                'name' => 'video',
                'type' => 'file',
                'return_format' => 'array',
                'required' => 0,
                'mime_types' => 'mp4,webm',
                'wrapper' => ['width' => 50],
            ],
        ]
    ];
}
