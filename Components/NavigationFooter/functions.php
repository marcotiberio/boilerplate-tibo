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
        'label' => __('Media', 'flynt'),
        'name' => 'mediaTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Logo', 'flynt'),
        'instructions' => __('Image-Format: JPG, PNG, SVG', 'flynt'),
        'name' => 'logoFooter',
        'type' => 'image',
        'preview_size' => 'full',
        'mime_types' => 'jpg,jpeg,png,svg,webp',
        'wrapper' => [
            'width' => 100
        ],
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
        'label' => __('Copyright', 'flynt'),
        'name' => 'copyrightTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Copyright', 'flynt'),
        'name' => 'copyrightHtml',
        'type' => 'text',
        'default_value' => sprintf(__('© %s, %s | All rights reserved', 'flynt'), date('Y'), get_bloginfo('name')),
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
                'label' => __('Aria Label', 'flynt'),
                'name' => 'ariaLabel',
                'type' => 'text',
                'default_value' => __('Footer', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
