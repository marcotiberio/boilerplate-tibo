<?php

namespace Flynt\Components\GridPosts;

use Flynt\Components\SliderCards;
use Timber\Timber;

/**
 * Article grid with pagination. Two uses:
 * - Page module "Listing: All News" (e.g. on /news/): queries the posts itself.
 * - Category/tag archives: templates/index.twig passes the main query's posts.
 */
add_filter('Flynt/addComponentData?name=GridPosts', function ($data) {
    $isArchive = isset($data['posts']);

    if ($isArchive) {
        $posts = $data['posts'];
        $data['title'] = wp_strip_all_tags(get_the_archive_title());
        $data['titleSize'] = 'h1';
        $data['titleTag'] = 'h1';
    } else {
        // Pages paginate as /news/page/2/ (paged) or /news/2/ (page).
        $paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
        $posts = Timber::get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => (int) ($data['postsPerPage'] ?? 0) ?: 12,
            'paged' => $paged,
        ]);
    }

    $data['isArchive'] = $isArchive;

    $data['cards'] = [];
    foreach ($posts as $post) {
        $data['cards'][] = SliderCards\postToCard($post);
    }

    $data['pagination'] = is_object($posts) && method_exists($posts, 'pagination')
        ? $posts->pagination(['mid_size' => 1])
        : null;

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'GridPosts',
        'label' => __('Listing: All News', 'flynt'),
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
                    'h1' => 'h1',
                    'h2' => 'h2',
                    'h3' => 'h3',
                    'h4' => 'h4',
                    'p' => 'p',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Articles per Page', 'flynt'),
                'instructions' => __('Newest first. Older articles are on the following pages.', 'flynt'),
                'name' => 'postsPerPage',
                'type' => 'number',
                'default_value' => 12,
                'min' => 3,
                'max' => 48,
                'step' => 3,
            ],
        ],
    ];
}
