<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt'),
        'navigation_cta' => __('Navigation CTA', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    $data['menu'] = Timber::get_menu('navigation_main') ?? Timber::get_pages_menu();
    $data['ctaMenu'] = Timber::get_menu('navigation_cta');
    $data['logo'] = [
        'src' => get_theme_mod('custom_header_logo') ? get_theme_mod('custom_header_logo') : Asset::requireUrl('assets/images/logo.svg'),
        'alt' => get_bloginfo('name')
    ];
    $data['categoryColor'] = getSingleProjectCategoryColor();

    return $data;
});

function getSingleProjectCategoryColor()
{
    if (!is_singular('post')) {
        return null;
    }

    $terms = get_the_terms(get_queried_object_id(), 'category');
    if (empty($terms) || is_wp_error($terms)) {
        return null;
    }

    $color = get_field('categoryColor', $terms[0]);

    return !empty($color) ? $color : null;
}

Options::addTranslatable('NavigationMain', [
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
                'default_value' => __('Main', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Toggle Menu', 'flynt'),
                'name' => 'toggleMenu',
                'type' => 'text',
                'default_value' => __('Toggle Menu', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
