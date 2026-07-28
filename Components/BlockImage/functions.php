<?php

namespace Flynt\Components\BlockImage;

function getACFLayout()
{
    return [
        'name' => 'BlockImage',
        'label' => __('Block: Image', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Media', 'flynt'),
                'name' => 'mediaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Variant', 'flynt'),
                'instructions' => __('Fullscreen spans the full width edge-to-edge. Framed sits inside the content width with rounded, softly waved edges.', 'flynt'),
                'name' => 'variant',
                'type' => 'select',
                'choices' => [
                    'framed' => __('Framed', 'flynt'),
                    'fullscreen' => __('Fullscreen', 'flynt'),
                ],
                'default_value' => 'framed',
                'required' => 1,
                'wrapper' => ['width' => 100],
            ],
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('JPG, PNG, SVG, WEBP. Also used as the poster/fallback when a video is set. The media Caption (set on the file) is shown on hover.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 1,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Video', 'flynt'),
                'instructions' => __('Optional. MP4/WebM. Plays muted and looped; the image above is used as poster/fallback. A play/pause control is shown when a video is set.', 'flynt'),
                'name' => 'video',
                'type' => 'file',
                'return_format' => 'array',
                'required' => 0,
                'mime_types' => 'mp4,webm',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Show full image on mobile', 'flynt'),
                'instructions' => __('By default the media is cropped to a 3:4 portrait on mobile. Enable to show the full media at its natural aspect ratio instead.', 'flynt'),
                'name' => 'showFullImageMobile',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 0,
                'wrapper' => ['width' => 100],
            ],
        ]
    ];
}
