<?php

/**
 * Project status: Laufend, Abgeschlossen.
 */

namespace Flynt\CustomTaxonomies;

function registerProjectStatusTaxonomy()
{
    $labels = [
        'name'          => _x('Statuses', 'Taxonomy General Name', 'flynt'),
        'singular_name' => _x('Status', 'Taxonomy Singular Name', 'flynt'),
        'menu_name'     => __('Statuses', 'flynt'),
        'all_items'     => __('All Statuses', 'flynt'),
        'new_item_name' => __('New Status', 'flynt'),
        'add_new_item'  => __('Add New Status', 'flynt'),
        'edit_item'     => __('Edit Status', 'flynt'),
        'update_item'   => __('Update Status', 'flynt'),
        'view_item'     => __('View Status', 'flynt'),
        'search_items'  => __('Search Statuses', 'flynt'),
        'not_found'     => __('Not Found', 'flynt'),
        'no_terms'      => __('No Statuses', 'flynt'),
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

    register_taxonomy('project-status', ['project'], $args);
}

add_action('init', 'Flynt\\CustomTaxonomies\\registerProjectStatusTaxonomy');
