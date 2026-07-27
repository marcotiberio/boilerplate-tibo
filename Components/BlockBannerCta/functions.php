<?php

namespace Flynt\Components\BlockBannerCta;

function getACFLayout()
{
    return [
        'name' => 'BlockBannerCta',
        'label' => __('Block: Banner CTA', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Eyebrow', 'flynt'),
                'instructions' => __('Small label shown above the title.', 'flynt'),
                'name' => 'eyebrow',
                'type' => 'text',
                'required' => 0,
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
                'default_value' => 'h2',
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
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
            ],
            [
                'label' => __('Primary Button', 'flynt'),
                'name' => 'primaryButton',
                'type' => 'link',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Secondary Button', 'flynt'),
                'name' => 'secondaryButton',
                'type' => 'link',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Media', 'flynt'),
                'name' => 'mediaTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Logo / Icon', 'flynt'),
                'instructions' => __('Centered layout: shown as a logo above the title. Split layout: shown as an icon in the top-right badge. Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
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
                    [
                        'label' => __('Layout', 'flynt'),
                        'name' => 'layout',
                        'type' => 'select',
                        'default_value' => 'centered',
                        'choices' => [
                            'centered' => __('Stacked — centered', 'flynt'),
                            'left' => __('Stacked — left aligned', 'flynt'),
                            'split' => __('Split (title / text side by side)', 'flynt'),
                        ],
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Theme', 'flynt'),
                        'name' => 'theme',
                        'type' => 'select',
                        'default_value' => 'beige',
                        'choices' => [
                            'beige' => __('Beige', 'flynt'),
                            'offWhite' => __('Off White', 'flynt'),
                            'terracotta' => __('Terracotta', 'flynt'),
                            'dark-green' => __('Dark Green', 'flynt'),
                        ],
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
        ],
    ];
}
