<?php

namespace Flynt\Components\ListingArticles;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListingArticles', function ($data) {
    $postsPerPage = $data['postsPerPage'] ?? -1;
    $postsPerPage = $postsPerPage ? (int) $postsPerPage : -1;

    $queryArgs = [
        'post_status'         => 'publish',
        'post_type'           => 'post',
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $postsPerPage,
        'orderby'             => 'date',
        'order'               => 'DESC',
    ];

    $posts = Timber::get_posts($queryArgs);

    $data['articles'] = [];
    $allCategories = [];
    foreach ($posts as $post) {
        $terms = wp_get_post_terms($post->ID, 'category', ['fields' => 'all']);
        $categorySlugs = [];
        foreach ($terms as $term) {
            $categorySlugs[] = $term->slug;
            $allCategories[$term->slug] = $term->name;
        }

        $data['articles'][] = [
            'post'           => $post,
            'postImage'      => $post->thumbnail(),
            'halftoneSvg'    => get_post_meta($post->ID, 'halftone_svg', true),
            'categorySlugs'       => $categorySlugs,
            'postIntro'           => get_field('postIntro', $post->ID),
            'postIntroHomepage'   => get_field('postIntroHomepage', $post->ID),
        ];
    }

    $showFiltering = $data['options']['showFiltering'] ?? false;
    $data['categories'] = $showFiltering ? $allCategories : [];

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingArticles',
        'label' => __('Listing: Articles', 'flynt'),
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
                'instructions' => __('Title displayed above the articles grid.', 'flynt'),
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
                'label' => __('Number of Posts', 'flynt'),
                'instructions' => __('Number of posts to display. Leave empty to show all.', 'flynt'),
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
                ]
            ]
        ],
    ];
}
