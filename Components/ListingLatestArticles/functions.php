<?php

namespace Flynt\Components\ListingLatestArticles;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ListingLatestArticles', function ($data) {
    $overridePost1 = !empty($data['overridePost1']) ? $data['overridePost1'] : null;
    $overridePost2 = !empty($data['overridePost2']) ? $data['overridePost2'] : null;

    if ($overridePost1 && $overridePost2) {
        $postIds = [
            is_object($overridePost1) ? $overridePost1->ID : intval($overridePost1),
            is_object($overridePost2) ? $overridePost2->ID : intval($overridePost2),
        ];
        $data['posts'] = Timber::get_posts([
            'post_type' => 'post',
            'post__in' => $postIds,
            'orderby' => 'post__in',
            'posts_per_page' => 2,
            'post_status' => 'publish',
        ]);
    } else {
        // Default: show 2nd and 3rd most recent articles (offset=1)
        $data['posts'] = Timber::get_posts([
            'post_type' => 'post',
            'posts_per_page' => 2,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);
    }

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
                'label' => __('Override Article 1', 'flynt'),
                'instructions' => __('Optional. If both overrides are set, they replace the automatic query (2nd & 3rd most recent).', 'flynt'),
                'name' => 'overridePost1',
                'type' => 'post_object',
                'post_type' => ['post'],
                'return_format' => 'object',
                'allow_null' => 1,
                'multiple' => 0,
                'required' => 0,
                'wrapper' => [
                    'width' => 50,
                ]
            ],
            [
                'label' => __('Override Article 2', 'flynt'),
                'instructions' => __('Optional. Both overrides must be set to activate manual selection.', 'flynt'),
                'name' => 'overridePost2',
                'type' => 'post_object',
                'post_type' => ['post'],
                'return_format' => 'object',
                'allow_null' => 1,
                'multiple' => 0,
                'required' => 0,
                'wrapper' => [
                    'width' => 50,
                ]
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
