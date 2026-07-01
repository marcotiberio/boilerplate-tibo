<?php

namespace Flynt\Components\BlockNewsSlider;

use Flynt\FieldVariables;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockNewsSlider', function ($data) {
    if (($data['source'] ?? 'static') === 'posts') {
        $data['cards'] = getPostCards($data['postCount'] ?? 6);
    } else {
        $data['cards'] = $data['cards'] ?? [];
    }

    $data['jsonData'] = [
        'options' => $data['options'] ?? [],
    ];

    return $data;
});

/**
 * Build a unified cards array from the latest posts.
 *
 * @param int $postCount
 * @return array
 */
function getPostCards($postCount)
{
    $postCount = (int) $postCount ?: 6;

    $posts = Timber::get_posts([
        'post_type' => 'post',
        'posts_per_page' => $postCount,
    ]);

    $cards = [];

    if (empty($posts)) {
        return $cards;
    }

    foreach ($posts as $post) {
        $thumbnail = get_the_post_thumbnail_url($post->ID, 'medium_large');
        $excerpt = $post->post_excerpt ?: $post->post_content;

        $cards[] = [
            'image' => [
                'src' => $thumbnail ?: '',
                'alt' => $post->title,
            ],
            'title' => $post->title,
            'excerpt' => wp_trim_words($excerpt, 24),
            'link' => [
                'url' => $post->link,
                'title' => __('Mehr lesen', 'flynt'),
            ],
        ];
    }

    return $cards;
}

function getACFLayout()
{
    return [
        'name' => 'BlockNewsSlider',
        'label' => 'Carousel: News Cards',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Content Source', 'flynt'),
                'name' => 'source',
                'type' => 'select',
                'choices' => [
                    'static' => __('Static cards', 'flynt'),
                    'posts' => __('Latest posts', 'flynt'),
                ],
                'default_value' => 'static',
                'ui' => 1,
            ],
            [
                'label' => __('Number of Posts', 'flynt'),
                'name' => 'postCount',
                'type' => 'number',
                'default_value' => 6,
                'min' => 1,
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'posts',
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Cards', 'flynt'),
                'name' => 'cards',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => __('Add Card', 'flynt'),
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'static',
                        ],
                    ],
                ],
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'required' => 0,
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                    ],
                    [
                        'label' => __('Excerpt', 'flynt'),
                        'name' => 'excerpt',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'link',
                        'type' => 'link',
                        'required' => 0,
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Enable Autoplay', 'flynt'),
                        'name' => 'autoplay',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                    [
                        'label' => __('Autoplay Speed (in milliseconds)', 'flynt'),
                        'name' => 'autoplaySpeed',
                        'type' => 'number',
                        'min' => 1,
                        'step' => 1,
                        'default_value' => 5000,
                        'required' => 0,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'autoplay',
                                    'operator' => '==',
                                    'value' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];
}
