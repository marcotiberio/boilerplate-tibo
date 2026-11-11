<?php

namespace Flynt\Components\BlockBannerCta;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockBannerCta',
        'label' => __('Block: Banner Cta', 'flynt'),
        'sub_fields' => [
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
                'name' => 'title',
                'type' => 'text',
                'wrapper' => [
                    'width' => 70,
                ],
            ],
            [
                'label' => __('Title Style', 'flynt'),
                'name' => 'titleStyle',
                'type' => 'select',
                'choices' => [
                    'heading' => __('Heading (uppercase)', 'flynt'),
                    'statement' => __('Statement (sentence case)', 'flynt'),
                ],
                'default_value' => 'heading',
                'return_format' => 'value',
                'wrapper' => [
                    'width' => 30,
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
            ],
            FieldVariables\getButtons(2),
            [
                'label' => __('Image', 'flynt'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Background Image', 'flynt'),
                'instructions' => __('Optional. Shown darkened behind the text.', 'flynt'),
                'name' => 'backgroundImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,webp',
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getSectionTheme('forest'),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
