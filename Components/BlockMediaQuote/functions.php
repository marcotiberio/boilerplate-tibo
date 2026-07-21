<?php

namespace Flynt\Components\BlockMediaQuote;

function getACFLayout()
{
    return [
        'name' => 'BlockMediaQuote',
        'label' => __('Block: Media Quote', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Media', 'flynt'),
                'name' => 'mediaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Background Video', 'flynt'),
                'instructions' => __('Optional. MP4/WebM. Plays muted and looped behind the quote; the image below is used as poster/fallback. A play/pause control is shown when a video is set.', 'flynt'),
                'name' => 'video',
                'type' => 'file',
                'return_format' => 'array',
                'required' => 0,
                'mime_types' => 'mp4,webm',
            ],
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('Poster/fallback when no video is set. Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
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
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Highlight', 'flynt'),
                'instructions' => __('Emphasised lead-in of the quote, shown in full white.', 'flynt'),
                'name' => 'highlight',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Quote', 'flynt'),
                'instructions' => __('Remainder of the quote, shown muted after the highlight.', 'flynt'),
                'name' => 'quote',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => '',
                'required' => 0,
            ],
        ]
    ];
}
