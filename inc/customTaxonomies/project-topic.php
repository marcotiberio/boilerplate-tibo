<?php

/**
 * Project topic (Thema): Bau, Bioökonomie, Kunststoff, Rohstoffe, Grenzüberschreitend.
 */

namespace Flynt\CustomTaxonomies;

function registerProjectTopicTaxonomy()
{
    $labels = [
        'name'          => _x('Topics', 'Taxonomy General Name', 'flynt'),
        'singular_name' => _x('Topic', 'Taxonomy Singular Name', 'flynt'),
        'menu_name'     => __('Topics', 'flynt'),
        'all_items'     => __('All Topics', 'flynt'),
        'new_item_name' => __('New Topic', 'flynt'),
        'add_new_item'  => __('Add New Topic', 'flynt'),
        'edit_item'     => __('Edit Topic', 'flynt'),
        'update_item'   => __('Update Topic', 'flynt'),
        'view_item'     => __('View Topic', 'flynt'),
        'search_items'  => __('Search Topics', 'flynt'),
        'not_found'     => __('Not Found', 'flynt'),
        'no_terms'      => __('No Topics', 'flynt'),
    ];
    $args = [
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'publicly_queryable' => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
        'show_in_rest'      => true,
        'rewrite'           => false,
    ];

    register_taxonomy('project-topic', ['project'], $args);
}

add_action('init', 'Flynt\\CustomTaxonomies\\registerProjectTopicTaxonomy');
