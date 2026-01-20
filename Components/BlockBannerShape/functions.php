<?php

namespace Flynt\Components\BlockBannerShape;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockBannerShape',
        'label' => __('Banner (with shape)', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 1,
                'required' => 1,
            ],
            [
                'label' => __('Image', 'flynt'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Background Image - Desktop', 'flynt'),
                'instructions' => __('Heart illustration or decorative background image. Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                'name' => 'backgroundImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Background Image - Mobile', 'flynt'),
                'instructions' => __('Heart illustration or decorative background image. Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                'name' => 'backgroundImageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            // [
            //     'label' => __('Form', 'flynt'),
            //     'name' => 'formTab',
            //     'type' => 'tab',
            //     'placement' => 'top',
            //     'endpoint' => 0
            // ],
            // [
            //     'label' => __('Form', 'flynt'),
            //     'name' => 'formHtml',
            //     'type' => 'wysiwyg',
            //     'tabs' => 'visual',
            //     'delay' => 1,
            //     'media_upload' => 0,
            //     'required' => 0,
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
