<?php

namespace Flynt\Components\GridPosts;

use Flynt\Components\SliderCards;

/**
 * News overview: the posts page set under Settings → Reading, plus post archives.
 * Rendered from templates/index.twig with the main query's posts.
 */
add_filter('Flynt/addComponentData?name=GridPosts', function ($data) {
    $posts = $data['posts'] ?? [];

    $data['cards'] = [];
    foreach ($posts as $post) {
        $data['cards'][] = SliderCards\postToCard($post);
    }

    $data['pagination'] = is_object($posts) && method_exists($posts, 'pagination')
        ? $posts->pagination(['mid_size' => 1])
        : null;

    $data['title'] = is_home()
        ? get_the_title((int) get_option('page_for_posts'))
        : wp_strip_all_tags(get_the_archive_title());

    return $data;
});
