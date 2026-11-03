<?php

/**
 * Roots & Shoots signup custom post type.
 *
 * Private archive of group signups sent through BlockFormRootsShoots. Every
 * submission is stored here before the notification email goes out, so no
 * signup is lost if the mail is not delivered. Not public, not in REST.
 */

namespace Flynt\CustomPostTypes;

function registerRootsShootsSignupPostType()
{
    $labels = [
        'name'               => _x('R&S Signups', 'Post Type General Name', 'flynt'),
        'singular_name'      => _x('R&S Signup', 'Post Type Singular Name', 'flynt'),
        'menu_name'          => __('R&S Signups', 'flynt'),
        'name_admin_bar'     => __('R&S Signup', 'flynt'),
        'all_items'          => __('All Signups', 'flynt'),
        'edit_item'          => __('View Signup', 'flynt'),
        'view_item'          => __('View Signup', 'flynt'),
        'search_items'       => __('Search Signups', 'flynt'),
        'not_found'          => __('Not found', 'flynt'),
        'not_found_in_trash' => __('Not found in Trash', 'flynt'),
        'items_list'         => __('Signups list', 'flynt'),
    ];
    $args = [
        'label'               => __('R&S Signup', 'flynt'),
        'description'         => __('Roots & Shoots group signups from the website form', 'flynt'),
        'labels'              => $labels,
        'supports'            => ['title', 'editor'],
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-groups',
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_in_rest'        => false,
        'capability_type'     => 'post',
        'capabilities'        => [
            // Signups only come in through the form.
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap'        => true,
    ];
    register_post_type('roots-shoots-signup', $args);
}

add_action('init', '\\Flynt\\CustomPostTypes\\registerRootsShootsSignupPostType');

/**
 * Keep the classic editor for signups.
 */
add_filter('use_block_editor_for_post_type', function ($useBlockEditor, $postType) {
    if ($postType === 'roots-shoots-signup') {
        return false;
    }
    return $useBlockEditor;
}, 10, 2);
