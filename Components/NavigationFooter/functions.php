<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Options;
use Flynt\Shortcodes;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    $data['maxLevel'] = 0;
    $data['menu'] = Timber::get_menu('navigation_footer') ?? Timber::get_pages_menu();

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
        'label' => __('Logo Mobile', 'flynt'),
        'name' => 'logoFooterMobile',
        'type' => 'image',
        'preview_size' => 'medium',
        'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
        'required' => 0,
        'mime_types' => 'jpg,jpeg,png,svg',
        'wrapper' =>  [
            'width' => 50,
        ]
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
            'width' => 50,
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
                'label' => __('Links', 'flynt'),
                'name' => 'links',
                'type' => 'repeater',
                'layout' => 'table',
                'min' => 0,
                'button_label' => __('Add Link', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'link',
                        'type' => 'link',
                        'required' => 1,
                        'wrapper' => [
                            'width' => 100
                        ],
                    ],
                ],
            ],
        ]
    ],
    [
        'label' => __('Newsletter', 'flynt'),
        'name' => 'newsletterTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Newsletter Link', 'flynt'),
        'name' => 'newsletterLink',
        'type' => 'link',
        'required' => 0,
        'wrapper' => [
            'width' => 100
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
