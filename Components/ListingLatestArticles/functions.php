<?php

namespace Flynt\Components\ListingLatestArticles;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListingLatestArticles', function ($data) {
    $numberOfPosts = !empty($data['numberOfPosts']) ? intval($data['numberOfPosts']) : 2;

    $args = [
        'post_type' => 'post',
        'posts_per_page' => $numberOfPosts,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
    ];

    $data['posts'] = Timber::get_posts($args);

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingLatestArticles',
        'label' => __('Listing: Latest Articles', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Number of Posts', 'flynt'),
                'instructions' => __('How many latest posts to display.', 'flynt'),
                'name' => 'numberOfPosts',
                'type' => 'number',
                'default_value' => 2,
                'min' => 1,
                'max' => 12,
                'required' => 0,
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
