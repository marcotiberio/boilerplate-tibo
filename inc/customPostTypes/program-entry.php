<?php

/**
 * Program Entry CPT.
 *
 * Public visitors submit entries through the FormProgramEntry component.
 * Submissions are created as `pending` and only become part of the program
 * (and appear on the BlockProgramMap) once the client reviews and publishes.
 */

namespace Flynt\CustomPostTypes;

function registerProgramEntryPostType()
{
    $labels = [
        'name'                  => _x('Program Entries', 'Post Type General Name', 'flynt'),
        'singular_name'         => _x('Program Entry', 'Post Type Singular Name', 'flynt'),
        'menu_name'             => __('Program', 'flynt'),
        'name_admin_bar'        => __('Program Entry', 'flynt'),
        'archives'              => __('Program Archives', 'flynt'),
        'all_items'             => __('All Entries', 'flynt'),
        'add_new_item'          => __('Add New Entry', 'flynt'),
        'add_new'               => __('Add New', 'flynt'),
        'new_item'              => __('New Entry', 'flynt'),
        'edit_item'             => __('Edit Entry', 'flynt'),
        'update_item'           => __('Update Entry', 'flynt'),
        'view_item'             => __('View Entry', 'flynt'),
        'view_items'            => __('View Entries', 'flynt'),
        'search_items'          => __('Search Entries', 'flynt'),
        'not_found'             => __('Not found', 'flynt'),
        'not_found_in_trash'    => __('Not found in Trash', 'flynt'),
        'featured_image'        => __('Featured Image', 'flynt'),
        'set_featured_image'    => __('Set featured image', 'flynt'),
        'remove_featured_image' => __('Remove featured image', 'flynt'),
        'use_featured_image'    => __('Use as featured image', 'flynt'),
        'items_list'            => __('Entries list', 'flynt'),
        'items_list_navigation' => __('Entries list navigation', 'flynt'),
        'filter_items_list'     => __('Filter entries list', 'flynt'),
    ];
    $args = [
        'label'                 => __('Program Entry', 'flynt'),
        'description'           => __('Public submissions for the program map', 'flynt'),
        'labels'                => $labels,
        'supports'              => ['title', 'thumbnail', 'revisions'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 9,
        'menu_icon'             => 'dashicons-location-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_rest'          => true,
        'can_export'            => true,
        'has_archive'           => true,
        'rewrite'               => ['slug' => 'program'],
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    ];
    register_post_type('program_entry', $args);
}

add_action('init', '\\Flynt\\CustomPostTypes\\registerProgramEntryPostType');

// Use the classic (TinyMCE) editor for program entries instead of Gutenberg.
add_filter('use_block_editor_for_post_type', function ($useBlockEditor, $postType) {
    if ($postType === 'program_entry') {
        return false;
    }
    return $useBlockEditor;
}, 10, 2);
