<?php

/**
 * This is an example file showcasing how you can add custom post types to your Flynt theme.
 *
 * For a full list of parameters see https://developer.wordpress.org/reference/functions/register_post_type/ or use https://generatewp.com/post-type/ to generate the code for you.
 */

// namespace Flynt\CustomPostTypes;

// function registerVideoPostType()
// {
//     $labels = [
//         'name'                  => _x('Videos', 'Post Type General Name', 'flynt'),
//         'singular_name'         => _x('Video', 'Post Type Singular Name', 'flynt'),
//         'menu_name'             => __('Videos', 'flynt'),
//         'name_admin_bar'        => __('Videos', 'flynt'),
//         'archives'              => __('Video Archives', 'flynt'),
//         'attributes'            => __('Video Attributes', 'flynt'),
//         'parent_item_colon'     => __('Parent Video:', 'flynt'),
//         'all_items'             => __('All Videos', 'flynt'),
//         'add_new_item'          => __('Add New Video', 'flynt'),
//         'add_new'               => __('Add New', 'flynt'),
//         'new_item'              => __('New Video', 'flynt'),
//         'edit_item'             => __('Edit Video', 'flynt'),
//         'update_item'           => __('Update Video', 'flynt'),
//         'view_item'             => __('View Video', 'flynt'),
//         'view_items'            => __('View Videos', 'flynt'),
//         'search_items'          => __('Search Video', 'flynt'),
//         'not_found'             => __('Not found', 'flynt'),
//         'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
//         'featured_image'        => __('Featured Image', 'flynt'),
//         'set_featured_image'    => __('Set featured image', 'flynt'),
//         'remove_featured_image' => __('Remove featured image', 'flynt'),
//         'use_featured_image'    => __('Use as featured image', 'flynt'),
//         'insert_into_item'      => __('Insert into video', 'flynt'),
//         'uploaded_to_this_item' => __('Uploaded to this video', 'flynt'),
//         'items_list'            => __('Videos list', 'flynt'),
//         'items_list_navigation' => __('Videos list navigation', 'flynt'),
//         'filter_items_list'     => __('Filter videos list', 'flynt'),
//     ];
//     $args = [
//         'label'                 => __('Video', 'flynt'),
//         'description'           => __('Video Description', 'flynt'),
//         'labels'                => $labels,
//         'supports'              => ['title', 'thumbnail', 'categories'],
//         'taxonomies'            => ['category'],
//         'hierarchical'          => false,
//         'public'                => true,
//         'show_ui'               => true,
//         'show_in_menu'          => true,
//         'menu_position'         => 8,
//         'menu_icon'             => 'dashicons-video-alt',
//         'show_in_admin_bar'     => true,
//         'show_in_nav_menus'     => true,
//         'can_export'            => true,
//         'has_archive'           => false,
//         'exclude_from_search'   => false,
//         'publicly_queryable'    => true,
//         'capability_type'       => 'page',
//     ];
//     register_post_type('video', $args);
// }

// add_action('init', '\\Flynt\\CustomPostTypes\\registerVideoPostType');
