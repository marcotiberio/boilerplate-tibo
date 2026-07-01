<?php

namespace Flynt\Components\ListingProjects;

use Flynt\FieldVariables;
use Flynt\Utils\Oembed;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListingProjects', function ($data) {
    $postsPerPage = $data['postsPerPage'] ?? -1;
    $postsPerPage = $postsPerPage ? (int) $postsPerPage : -1;

    $queryArgs = [
        'post_status'         => 'publish',
        'post_type'           => 'post',
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $postsPerPage,
        'orderby'             => 'menu',
    ];

    $posts = Timber::get_posts($queryArgs);

    $data['projects'] = [];
    foreach ($posts as $post) {
        $categoryTerms = get_the_terms($post->ID, 'category');
        $categorySlugs = !empty($categoryTerms) && !is_wp_error($categoryTerms)
            ? wp_list_pluck($categoryTerms, 'slug')
            : [];
        $locationSlugs = wp_get_post_terms($post->ID, 'location', ['fields' => 'slugs']);

        $categoryColor = null;
        if (!empty($categoryTerms) && !is_wp_error($categoryTerms)) {
            $color = get_field('categoryColor', $categoryTerms[0]);
            if (!empty($color)) {
                $categoryColor = $color;
            }
        }

        if (!empty($post->featVideoEmbed)) {
            $post->featVideoEmbed = Oembed::setSrcAsDataAttribute(
                $post->featVideoEmbed,
                [
                    'autoplay' => 'true',
                    'loop'     => 'true',
                    'muted'    => 'true',
                    'controls' => 'false',
                ]
            );
        }

        $data['projects'][] = [
            'project'        => $post,
            'categorySlugs'  => $categorySlugs,
            'locationSlugs'  => is_array($locationSlugs) ? $locationSlugs : [],
            'categoryColor'  => $categoryColor,
        ];
    }

    $showFiltering = $data['options']['showFiltering'] ?? false;
    $data['categories'] = $showFiltering ? termsAsSlugNameMap('category', [
        'exclude' => [(int) get_option('default_category')],
    ]) : [];
    $data['categoryColors'] = $showFiltering ? termsAsSlugColorMap('category', [
        'exclude' => [(int) get_option('default_category')],
    ]) : [];
    $data['locations']  = $showFiltering ? termsAsSlugNameMap('location') : [];

    return $data;
});

function termsAsSlugColorMap(string $taxonomy, array $extraArgs = []): array
{
    $terms = get_terms(array_merge([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ], $extraArgs));

    if (is_wp_error($terms) || !is_array($terms)) {
        return [];
    }

    $map = [];
    foreach ($terms as $term) {
        $color = get_field('categoryColor', $term);
        $map[$term->slug] = !empty($color) ? $color : null;
    }
    return $map;
}

function termsAsSlugNameMap(string $taxonomy, array $extraArgs = []): array
{
    $terms = get_terms(array_merge([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ], $extraArgs));

    if (is_wp_error($terms) || !is_array($terms)) {
        return [];
    }

    $map = [];
    foreach ($terms as $term) {
        $map[$term->slug] = $term->name;
    }
    return $map;
}

function getACFLayout()
{
    return [
        'name' => 'ListingProjects',
        'label' => __('Listing: Projects', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Block Title', 'flynt'),
                'instructions' => __('Title displayed above the projects grid.', 'flynt'),
                'name' => 'blockTitle',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('See All Link', 'flynt'),
                'instructions' => __('Link for the "See All" button.', 'flynt'),
                'name' => 'seeAllLink',
                'type' => 'link',
                'return_format' => 'array',
                'required' => 0,
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Number of Projects', 'flynt'),
                'instructions' => __('Number of projects to display. Leave empty to show all.', 'flynt'),
                'name' => 'postsPerPage',
                'type' => 'number',
                'min' => 1,
                'required' => 0,
                'wrapper' => [
                    'width' => 33,
                ],
            ],
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
                    [
                        'label' => __('Top Border', 'flynt'),
                        'name' => 'topBorder',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Show Filtering', 'flynt'),
                        'instructions' => __('Show or hide the category filter.', 'flynt'),
                        'name' => 'showFiltering',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Reset Label', 'flynt'),
                        'instructions' => __('Label for the "Reset all" filter button.', 'flynt'),
                        'name' => 'resetLabel',
                        'type' => 'text',
                        'default_value' => __('Reset all', 'flynt'),
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                ]
            ]
        ],
    ];
}
