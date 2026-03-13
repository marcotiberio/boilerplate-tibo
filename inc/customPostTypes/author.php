<?php

/**
 * This is an example file showcasing how you can add custom post types to your Flynt theme.
 *
 * For a full list of parameters see https://developer.wordpress.org/reference/functions/register_post_type/ or use https://generatewp.com/post-type/ to generate the code for you.
 */

namespace Flynt\CustomPostTypes;

function registerAuthorPostType()
{
    $labels = [
        'name'                  => _x('Authors', 'Post Type General Name', 'flynt'),
        'singular_name'         => _x('Author', 'Post Type Singular Name', 'flynt'),
        'menu_name'             => __('Authors', 'flynt'),
        'name_admin_bar'        => __('Authors', 'flynt'),
        'archives'              => __('Author Archives', 'flynt'),
        'attributes'            => __('Author Attributes', 'flynt'),
        'parent_item_colon'     => __('Parent Author:', 'flynt'),
        'all_items'             => __('All Authors', 'flynt'),
        'add_new_item'          => __('Add New Author', 'flynt'),
        'add_new'               => __('Add New', 'flynt'),
        'new_item'              => __('New Author', 'flynt'),
        'edit_item'             => __('Edit Author', 'flynt'),
        'update_item'           => __('Update Author', 'flynt'),
        'view_item'             => __('View Author', 'flynt'),
        'view_items'            => __('View Authors', 'flynt'),
        'search_items'          => __('Search Authors', 'flynt'),
        'not_found'             => __('Not found', 'flynt'),
        'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
        'featured_image'        => __('Featured Image', 'flynt'),
        'set_featured_image'    => __('Set featured image', 'flynt'),
        'remove_featured_image' => __('Remove featured image', 'flynt'),
        'use_featured_image'    => __('Use as featured image', 'flynt'),
        'insert_into_item'      => __('Insert into author', 'flynt'),
        'uploaded_to_this_item' => __('Uploaded to this author', 'flynt'),
        'items_list'            => __('Authors list', 'flynt'),
        'items_list_navigation' => __('Authors list navigation', 'flynt'),
        'filter_items_list'     => __('Filter authors list', 'flynt'),
    ];
    $args = [
        'label'                 => __('Author', 'flynt'),
        'description'           => __('Author Description', 'flynt'),
        'labels'                => $labels,
        'supports'              => ['title', 'thumbnail'],
        'taxonomies'            => ['post_tag'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 8,
        'menu_icon'             => 'dashicons-businessperson',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false, // Don't show in nav menus
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true, // Allow single-author.php to execute
        // 'capability_type'       => 'post',
        'show_in_rest'          => false,
        'rewrite'               => [
            'slug' => 'authors',
            'with_front' => false,
        ],
    ];
    register_post_type('author', $args);
}

add_action('init', '\\Flynt\\CustomPostTypes\\registerAuthorPostType');
