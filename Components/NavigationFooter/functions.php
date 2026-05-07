<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Flynt\Shortcodes;
use Timber\Timber;

const SOCIAL_PLATFORMS = [
    'facebook'  => 'Facebook',
    'instagram' => 'Instagram',
    'linkedin'  => 'LinkedIn',
    'x'         => 'X / Twitter',
    'youtube'   => 'YouTube',
    'tiktok'    => 'TikTok',
    'email'     => 'Email',
    'website'   => 'Website',
];

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    $data['maxLevel'] = 0;
    $data['menu'] = Timber::get_menu('navigation_footer') ?? Timber::get_pages_menu();

    if (!empty($data['socialLinks']) && is_array($data['socialLinks'])) {
        $data['socialLinks'] = array_values(array_filter(array_map(function ($link) {
            if (empty($link['platform']) || empty($link['url'])) {
                return null;
            }
            $iconPath = "assets/icons/{$link['platform']}.svg";
            $link['iconUrl'] = Asset::requireUrl($iconPath);
            $link['label']   = SOCIAL_PLATFORMS[$link['platform']] ?? $link['platform'];
            return $link;
        }, $data['socialLinks'])));
    }

    return $data;
});

Options::addTranslatable('NavigationFooter', [
    [
        'label' => __('Logo', 'flynt'),
        'name' => 'logoTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Logo', 'flynt'),
        'name' => 'logoFooter',
        'type' => 'image',
        'preview_size' => 'medium',
        'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
        'required' => 0,
        'mime_types' => 'jpg,jpeg,png,svg',
        'wrapper' =>  [
            'width' => 100,
        ]
    ],
    [
        'label' => __('Copyrighs', 'flynt'),
        'name' => 'copyrightsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Copyrights', 'flynt'),
        'name' => 'copyrightsHtml',
        'type' => 'wysiwyg',
        'tabs' => 'visual,text',
        'toolbar' => 'default',
        'media_upload' => 0,
        'delay' => 1
    ],
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Columns', 'flynt'),
        'name' => 'columns',
        'type' => 'repeater',
        'layout' => 'block',
        'min' => 1,
        'max' => 4,
        'button_label' => __('Add Column', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
                'wrapper' => [
                    'width' => 100
                ],
            ],
        ]
    ],
    [
        'label' => __('Social', 'flynt'),
        'name' => 'socialTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Social Links', 'flynt'),
        'name' => 'socialLinks',
        'type' => 'repeater',
        'layout' => 'table',
        'min' => 0,
        'button_label' => __('Add Social Link', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Platform', 'flynt'),
                'name' => 'platform',
                'type' => 'select',
                'choices' => SOCIAL_PLATFORMS,
                'required' => 1,
                'allow_null' => 0,
                'wrapper' => [
                    'width' => '30',
                ],
            ],
            [
                'label' => __('URL', 'flynt'),
                'name' => 'url',
                'type' => 'url',
                'required' => 1,
                'wrapper' => [
                    'width' => '70',
                ],
            ],
        ],
    ],
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Light Theme', 'flynt'),
                'name' => 'themeLight',
                'type' => 'text',
                'default_value' => __('Dunkel', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Dark Theme', 'flynt'),
                'name' => 'themeDark',
                'type' => 'text',
                'default_value' => __('Hell', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Aria Label', 'flynt'),
                'name' => 'ariaLabel',
                'type' => 'text',
                'default_value' => __('Footer', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '100',
                ],
            ],
        ],
    ],
]);
