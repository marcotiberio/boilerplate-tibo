<?php

namespace Flynt\Components\BlockGallery;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockGallery',
        'label' => __('Block: Gallery', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Headline', 'flynt'),
                'instructions' => __('Optional section heading shown above the grid.', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Headline Size', 'flynt'),
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
                'label' => __('Headline Tag', 'flynt'),
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
                'label' => __('Cards', 'flynt'),
                'instructions' => __('Image cards. The image shows on hover a centered icon and the headline.', 'flynt'),
                'name' => 'cards',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add Card', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'instructions' => __('Image-Format: JPG, PNG.', 'flynt'),
                        'name' => 'media',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'required' => 1,
                        'mime_types' => 'jpg,jpeg,png',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Width', 'flynt'),
                        'instructions' => __('Wide spans two columns on larger screens.', 'flynt'),
                        'name' => 'width',
                        'type' => 'button_group',
                        'choices' => [
                            '' => sprintf('<p>%s</p>', __('Normal', 'flynt')),
                            'sm:col-span-2' => sprintf('<p>%s</p>', __('Wide', 'flynt')),
                        ],
                        'default_value' => '',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Headline', 'flynt'),
                        'instructions' => __('Shown over the image on hover.', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Icon', 'flynt'),
                        'instructions' => __('Centered over the image on hover. Image-Format: SVG, PNG.', 'flynt'),
                        'name' => 'icon',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'required' => 0,
                        'mime_types' => 'svg,png',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'instructions' => __('Makes the whole card clickable.', 'flynt'),
                        'name' => 'link',
                        'type' => 'link',
                        'required' => 0,
                    ],
                ],
            ],
            [
                'label' => __('Text Card', 'flynt'),
                'name' => 'textCardTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'instructions' => __('Optional promo card shown as the last cell of the grid.', 'flynt'),
                'name' => 'textCard',
                'type' => 'group',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'label' => __('Icon', 'flynt'),
                        'instructions' => __('Shown in the top-left badge. Image-Format: SVG, PNG.', 'flynt'),
                        'name' => 'icon',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'required' => 0,
                        'mime_types' => 'svg,png',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Headline', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 0,
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Paragraph', 'flynt'),
                        'name' => 'text',
                        'type' => 'textarea',
                        'rows' => 3,
                        'new_lines' => 'br',
                        'required' => 0,
                    ],
                    [
                        'label' => __('Button', 'flynt'),
                        'name' => 'button',
                        'type' => 'link',
                        'required' => 0,
                    ],
                ],
            ],
        ],
    ];
}
