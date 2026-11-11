<?php

/**
 * Audience (Zielgruppe), shared by projects and publications: Kommunen, Unternehmen, Land & Politik, Förderer.
 */

namespace Flynt\CustomTaxonomies;

function registerAudienceTaxonomy()
{
    $labels = [
        'name'          => _x('Audiences', 'Taxonomy General Name', 'flynt'),
        'singular_name' => _x('Audience', 'Taxonomy Singular Name', 'flynt'),
        'menu_name'     => __('Audiences', 'flynt'),
        'all_items'     => __('All Audiences', 'flynt'),
        'new_item_name' => __('New Audience', 'flynt'),
        'add_new_item'  => __('Add New Audience', 'flynt'),
        'edit_item'     => __('Edit Audience', 'flynt'),
        'update_item'   => __('Update Audience', 'flynt'),
        'view_item'     => __('View Audience', 'flynt'),
        'search_items'  => __('Search Audiences', 'flynt'),
        'not_found'     => __('Not Found', 'flynt'),
        'no_terms'      => __('No Audiences', 'flynt'),
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

    register_taxonomy('audience', ['project', 'post'], $args);
}

add_action('init', 'Flynt\\CustomTaxonomies\\registerAudienceTaxonomy');
