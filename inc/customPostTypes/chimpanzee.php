<?php

/**
 * Chimpanzee custom post type.
 *
 * Powers the sponsorship ("Patenschaft") cards — each chimpanzee has a photo
 * (featured image), a name (post title), a gender (ACF field) and a description
 * (excerpt). Used as a content source in the SliderCards carousel.
 */

namespace Flynt\CustomPostTypes;

function registerChimpanzeePostType()
{
    $labels = [
        'name'                  => _x('Chimpanzees', 'Post Type General Name', 'flynt'),
        'singular_name'         => _x('Chimpanzee', 'Post Type Singular Name', 'flynt'),
        'menu_name'             => __('Chimpanzees', 'flynt'),
        'name_admin_bar'        => __('Chimpanzee', 'flynt'),
        'archives'              => __('Chimpanzee Archives', 'flynt'),
        'attributes'            => __('Chimpanzee Attributes', 'flynt'),
        'parent_item_colon'     => __('Parent Chimpanzee:', 'flynt'),
        'all_items'             => __('All Chimpanzees', 'flynt'),
        'add_new_item'          => __('Add New Chimpanzee', 'flynt'),
        'add_new'               => __('Add New', 'flynt'),
        'new_item'              => __('New Chimpanzee', 'flynt'),
        'edit_item'             => __('Edit Chimpanzee', 'flynt'),
        'update_item'           => __('Update Chimpanzee', 'flynt'),
        'view_item'             => __('View Chimpanzee', 'flynt'),
        'view_items'            => __('View Chimpanzees', 'flynt'),
        'search_items'          => __('Search Chimpanzees', 'flynt'),
        'not_found'             => __('Not found', 'flynt'),
        'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
        'featured_image'        => __('Photo', 'flynt'),
        'set_featured_image'    => __('Set photo', 'flynt'),
        'remove_featured_image' => __('Remove photo', 'flynt'),
        'use_featured_image'    => __('Use as photo', 'flynt'),
        'items_list'            => __('Chimpanzees list', 'flynt'),
        'items_list_navigation' => __('Chimpanzees list navigation', 'flynt'),
        'filter_items_list'     => __('Filter chimpanzees list', 'flynt'),
    ];
    $args = [
        'label'                 => __('Chimpanzee', 'flynt'),
        'description'           => __('Chimpanzees available for sponsorship', 'flynt'),
        'labels'                => $labels,
        'supports'              => ['title', 'thumbnail',],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-pets',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'capability_type'       => 'post',
        'rewrite'               => ['slug' => 'chimpanzee'],
    ];
    register_post_type('chimpanzee', $args);
}

add_action('init', '\\Flynt\\CustomPostTypes\\registerChimpanzeePostType');

/**
 * Force the classic editor for the Chimpanzee CPT (keeps REST enabled for ACF).
 */
add_filter('use_block_editor_for_post_type', function ($useBlockEditor, $postType) {
    if ($postType === 'chimpanzee') {
        return false;
    }
    return $useBlockEditor;
}, 10, 2);
