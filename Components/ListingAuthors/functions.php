<?php

namespace Flynt\Components\ListingAuthors;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListingAuthors', function ($data) {
    $queryArgs = [
        'post_status'         => 'publish',
        'post_type'           => 'author',
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => -1,
        'orderby'             => 'date',
        'order'               => 'menu_order',
        'tax_query'           => [
            [
                'taxonomy' => 'post_tag',
                'field'    => 'slug',
                'terms'    => ['guest'],
                'operator' => 'NOT IN',
            ],
        ],
    ];

    // Limit to a single role-category term when one is selected in the backend.
    if (!empty($data['roleCategory'])) {
        $queryArgs['tax_query'][] = [
            'taxonomy' => 'role-category',
            'field'    => 'term_id',
            'terms'    => [$data['roleCategory']->term_id],
        ];
    }

    $posts = Timber::get_posts($queryArgs);

    $themeUri = trailingslashit(get_template_directory_uri());

    $data['authors'] = [];
    foreach ($posts as $post) {
        $socials = get_field('authorSocials', $post->ID) ?: [];
        $socials = array_map(function ($item) use ($themeUri) {
            $item['iconUrl'] = $themeUri . 'assets/icons/' . $item['platform'] . '.svg';
            return $item;
        }, $socials);

        $data['authors'][] = [
            'post'        => $post,
            'postImage'   => $post->thumbnail(),
            'socials'     => $socials,
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingAuthors',
        'label' => __('Listing: Authors', 'flynt'),
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
            ],
            [
                'label' => __('See All Link', 'flynt'),
                'instructions' => __('Link for the "See All" button.', 'flynt'),
                'name' => 'seeAllLink',
                'type' => 'link',
                'return_format' => 'array',
                'required' => 0,
            ],
            [
                'label' => __('Role', 'flynt'),
                'instructions' => __('Select a role to only show authors with that term, or leave empty to show all authors.', 'flynt'),
                'name' => 'roleCategory',
                'type' => 'taxonomy',
                'taxonomy' => 'role-category',
                'field_type' => 'select',
                'allow_null' => 1,
                'multiple' => 0,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object',
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
                    ],
                ]
            ]
        ],
    ];
}
