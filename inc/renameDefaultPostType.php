<?php

/**
 * Default posts are used as publications (Publikationen); the category taxonomy is the publication type (Typ).
 */

add_filter('post_type_labels_post', 'post_rename_labels');

/**
 * Rename default post type to Publikationen.
 *
 * @param object $labels
 * @hooked post_type_labels_post
 * @return object $labels
 */
function post_rename_labels($labels)
{
    $labels->name = 'Publikationen';
    $labels->singular_name = 'Publikation';
    $labels->add_new_item = 'Neue Publikation';
    $labels->edit_item = 'Publikation bearbeiten';
    $labels->all_items = 'Alle Publikationen';
    $labels->search_items = 'Publikationen durchsuchen';

    $labels->menu_name = 'Publikationen';
    $labels->name_admin_bar = 'Publikation';

    return $labels;
}

add_filter('register_taxonomy_args', function ($args, $taxonomy) {
    if ($taxonomy !== 'category') {
        return $args;
    }
    $args['labels'] = array_merge((array) ($args['labels'] ?? []), [
        'name' => 'Typen',
        'singular_name' => 'Typ',
        'menu_name' => 'Typen',
        'all_items' => 'Alle Typen',
        'add_new_item' => 'Neuer Typ',
        'edit_item' => 'Typ bearbeiten',
    ]);
    return $args;
}, 10, 2);
