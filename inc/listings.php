<?php

/**
 * Helpers shared by the listing components (projects, publications, events).
 */

namespace Flynt\Listings;

/**
 * Filter chip group for a taxonomy, limited to terms in use.
 *
 * @return array{key: string, label: string, terms: array<int, array{slug: string, name: string}>}
 */
function getFilterGroup($taxonomy, $key, $label)
{
    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
    ]);
    if (is_wp_error($terms)) {
        $terms = [];
    }

    return [
        'key' => $key,
        'label' => $label,
        'terms' => array_map(function ($term) {
            return [
                'slug' => $term->slug,
                'name' => $term->name,
            ];
        }, $terms),
    ];
}

/**
 * Term slugs and names of a post for one taxonomy.
 *
 * @return array{slugs: string[], names: string[]}
 */
function getPostTerms($postId, $taxonomy)
{
    $terms = get_the_terms($postId, $taxonomy);
    if (empty($terms) || is_wp_error($terms)) {
        return ['slugs' => [], 'names' => []];
    }

    return [
        'slugs' => wp_list_pluck($terms, 'slug'),
        'names' => wp_list_pluck($terms, 'name'),
    ];
}

/**
 * Excerpt without the "read more" suffix; falls back to trimmed content.
 */
function getExcerpt($post, $words = 30)
{
    $post = get_post($post);
    if (!$post) {
        return '';
    }
    $text = has_excerpt($post) ? $post->post_excerpt : wp_strip_all_tags(strip_shortcodes($post->post_content));

    return wp_trim_words($text, $words, '…');
}

/**
 * Post IDs for a listing: hand-picked in teaser mode, otherwise latest / all.
 *
 * @return int[]
 */
function getPostIds($postType, $mode, $source, $picked, $teaserCount = 3)
{
    if ($mode === 'teaser' && $source === 'manual' && !empty($picked)) {
        return array_map(function ($post) {
            return is_object($post) ? $post->ID : (int) $post;
        }, (array) $picked);
    }

    return get_posts([
        'post_type' => $postType,
        'post_status' => 'publish',
        'posts_per_page' => $mode === 'teaser' ? $teaserCount : -1,
        'fields' => 'ids',
        'no_found_rows' => true,
    ]);
}
