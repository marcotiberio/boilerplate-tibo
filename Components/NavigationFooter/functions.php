<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Options;

Options::addTranslatable('NavigationFooter', [
    [
        'label' => __('Newsletter', 'flynt'),
        'name' => 'newsletterTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Newsletter Heading', 'flynt'),
        'name' => 'newsletterHeading',
        'type' => 'text',
        'default_value' => __('Immer auf dem Laufenden bleiben! Newsletter abonnieren.', 'flynt'),
        'wrapper' => [
            'width' => '100',
        ],
    ],
    [
        'label' => __('Newsletter Image', 'flynt'),
        'instructions' => __('Image-Format: JPG, PNG, WEBP.', 'flynt'),
        'name' => 'newsletterImage',
        'type' => 'image',
        'preview_size' => 'medium',
        'mime_types' => 'jpg,jpeg,png,webp',
        'wrapper' => [
            'width' => '100',
        ],
    ],
    [
        'label' => __('Input Placeholder', 'flynt'),
        'name' => 'newsletterPlaceholder',
        'type' => 'text',
        'default_value' => 'E-Mail Adresse',
        'wrapper' => [
            'width' => '50',
        ],
    ],
    [
        'label' => __('Submit Button Label', 'flynt'),
        'name' => 'newsletterButtonLabel',
        'type' => 'text',
        'default_value' => 'Anmelden',
        'wrapper' => [
            'width' => '50',
        ],
    ],
    [
        'label' => __('Brand', 'flynt'),
        'name' => 'brandTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Brand Title', 'flynt'),
        'name' => 'brandTitle',
        'type' => 'text',
        'wrapper' => [
            'width' => '100',
        ],
    ],
    [
        'label' => __('Organisation Name', 'flynt'),
        'name' => 'orgName',
        'type' => 'text',
        'wrapper' => [
            'width' => '100',
        ],
    ],
    [
        'label' => __('Address', 'flynt'),
        'name' => 'address',
        'type' => 'textarea',
        'rows' => 2,
        'wrapper' => [
            'width' => '100',
        ],
    ],
    [
        'label' => __('Phone', 'flynt'),
        'name' => 'phone',
        'type' => 'text',
        'wrapper' => [
            'width' => '50',
        ],
    ],
    [
        'label' => __('Email', 'flynt'),
        'name' => 'email',
        'type' => 'email',
        'wrapper' => [
            'width' => '50',
        ],
    ],
    [
        'label' => __('Socials', 'flynt'),
        'name' => 'socials',
        'type' => 'repeater',
        'layout' => 'table',
        'button_label' => __('Add Social', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Platform', 'flynt'),
                'name' => 'platform',
                'type' => 'select',
                'choices' => [
                    'linkedin' => 'LinkedIn',
                    'instagram' => 'Instagram',
                    'youtube' => 'YouTube',
                    'facebook' => 'Facebook',
                    'x' => 'X',
                    'tiktok' => 'TikTok',
                    'website' => 'Website',
                    'email' => 'Email',
                ],
                'wrapper' => [
                    'width' => '40',
                ],
            ],
            [
                'label' => __('URL', 'flynt'),
                'name' => 'url',
                'type' => 'url',
                'wrapper' => [
                    'width' => '60',
                ],
            ],
        ],
    ],
    [
        'label' => __('Donate Link', 'flynt'),
        'name' => 'donateLink',
        'type' => 'link',
        'return_format' => 'array',
        'wrapper' => [
            'width' => '100',
        ],
    ],
    [
        'label' => __('Transparency Badge', 'flynt'),
        'instructions' => __('White logo shown bottom-right (e.g. Initiative Transparente Zivilgesellschaft). PNG or SVG.', 'flynt'),
        'name' => 'transparencyBadge',
        'type' => 'image',
        'preview_size' => 'medium',
        'mime_types' => 'png,svg,webp',
        'wrapper' => [
            'width' => '60',
        ],
    ],
    [
        'label' => __('Transparency Badge Link', 'flynt'),
        'name' => 'transparencyBadgeLink',
        'type' => 'url',
        'wrapper' => [
            'width' => '40',
        ],
    ],
    [
        'label' => __('Columns', 'flynt'),
        'name' => 'columnsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Columns', 'flynt'),
        'name' => 'columns',
        'type' => 'repeater',
        'layout' => 'block',
        'button_label' => __('Add Column', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Heading', 'flynt'),
                'name' => 'heading',
                'type' => 'text',
                'wrapper' => [
                    'width' => '100',
                ],
            ],
            [
                'label' => __('Links', 'flynt'),
                'name' => 'links',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __('Add Link', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                    ],
                ],
            ],
        ],
    ],
    [
        'label' => __('Legal', 'flynt'),
        'name' => 'legalTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Legal Links', 'flynt'),
        'name' => 'legalLinks',
        'type' => 'repeater',
        'layout' => 'table',
        'button_label' => __('Add Legal Link', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Link', 'flynt'),
                'name' => 'link',
                'type' => 'link',
                'return_format' => 'array',
            ],
        ],
    ],
    [
        'label' => __('Copyright Text', 'flynt'),
        'name' => 'copyrightText',
        'type' => 'text',
        'wrapper' => [
            'width' => '100',
        ],
    ],
]);
