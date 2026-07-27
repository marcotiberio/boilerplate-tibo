<?php

namespace Flynt\Components\SliderCards;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=SliderCards', function ($data) {
    $source = $data['source'] ?? 'static';

    if ($source === 'projects') {
        $data['cards'] = getPostCards('post', $data['postCount'] ?? 8);
    } elseif ($source === 'chimpanzee') {
        $data['cards'] = getChimpanzeeCards($data['postCount'] ?? 8);
    } else {
        $data['cards'] = $data['cards'] ?? [];
    }

    $data['jsonData'] = [
        'options' => $data['options'] ?? [],
    ];

    return $data;
});

/**
 * Build cards from the latest posts of a given post type (Projects).
 *
 * @param string $postType
 * @param int $postCount
 * @return array
 */
function getPostCards($postType, $postCount)
{
    $postCount = (int) $postCount ?: 8;

    $posts = Timber::get_posts([
        'post_type' => $postType,
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

/**
 * Build sponsorship cards from the Chimpanzee CPT.
 * Name = post title, gender = ACF field, photo = featured image,
 * and the CTA links to the chimpanzee's own page.
 *
 * @param int $postCount
 * @return array
 */
function getChimpanzeeCards($postCount)
{
    $postCount = (int) $postCount ?: 8;

    $posts = Timber::get_posts([
        'post_type' => 'chimpanzee',
        'posts_per_page' => $postCount,
    ]);

    $cards = [];

    if (empty($posts)) {
        return $cards;
    }

    foreach ($posts as $post) {
        $thumbnail = get_the_post_thumbnail_url($post->ID, 'medium_large');
        $sex = get_field('sex', $post->ID);
        $description = get_field('description', $post->ID) ?: ($post->post_excerpt ?: $post->post_content);

        $cards[] = [
            'image' => [
                'src' => $thumbnail ?: '',
                'alt' => $post->title,
            ],
            'title' => $post->title,
            'subtitle' => $sex ?: '',
            'excerpt' => wp_trim_words($description, 24),
            'link' => [
                'url' => $post->link,
                // e.g. "Mawa" → "Mawas Pate werden"
                'title' => sprintf(__('%ss Pate werden', 'flynt'), $post->title),
            ],
        ];
    }

    return $cards;
}

function getACFLayout()
{
    return [
        'name' => 'SliderCards',
        'label' => 'Carousel: Cards',
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
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Title Size', 'flynt'),
                'instructions' => __('Visual size of the headline.', 'flynt'),
                'name' => 'titleSize',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Title Tag', 'flynt'),
                'instructions' => __('HTML tag used for the headline (accessibility / SEO).', 'flynt'),
                'name' => 'titleTag',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Content Source', 'flynt'),
                'name' => 'source',
                'type' => 'select',
                'choices' => [
                    'static' => __('Free content', 'flynt'),
                    'projects' => __('Projects', 'flynt'),
                    'chimpanzee' => __('Chimpanzees', 'flynt'),
                ],
                'default_value' => 'static',
                'ui' => 1,
            ],
            [
                'label' => __('Number of Items', 'flynt'),
                'name' => 'postCount',
                'type' => 'number',
                'default_value' => 8,
                'min' => 1,
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'projects',
                        ],
                    ],
                    [
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'chimpanzee',
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
        ],
    ];
}
