<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    $data['menu'] = Timber::get_menu('navigation_footer');

    return $data;
});

Options::addTranslatable('NavigationFooter', [
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Menu Title', 'flynt'),
        'name' => 'menuTitle',
        'type' => 'text',
        'default_value' => 'Übersicht',
        'wrapper' => [
            'width' => 50
        ],
    ],
    [
        'label' => __('Contact Title', 'flynt'),
        'name' => 'contactTitle',
        'type' => 'text',
        'default_value' => 'Kontakt',
        'wrapper' => [
            'width' => 50
        ],
    ],
    [
        'label' => __('Contact', 'flynt'),
        'instructions' => __('Address, email and phone.', 'flynt'),
        'name' => 'contactHtml',
        'type' => 'wysiwyg',
        'tabs' => 'visual,text',
        'toolbar' => 'basic',
        'media_upload' => 0,
        'delay' => 1
    ],
    [
        'label' => __('Social', 'flynt'),
        'name' => 'socialTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Instagram URL', 'flynt'),
        'name' => 'instagramUrl',
        'type' => 'url',
        'wrapper' => [
            'width' => 50
        ],
    ],
    [
        'label' => __('LinkedIn URL', 'flynt'),
        'name' => 'linkedinUrl',
        'type' => 'url',
        'wrapper' => [
            'width' => 50
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
                    'width' => '100',
                ],
            ],
        ],
    ],
]);
