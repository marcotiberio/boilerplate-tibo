<?php

/**
 * Stop public username enumeration. Authors on this site are a CPT, so WP users are never shown publicly.
 */

namespace Flynt\HideUsers;

// Remove the users REST routes for visitors.
add_filter('rest_endpoints', function ($endpoints) {
    if (is_user_logged_in()) {
        return $endpoints;
    }

    foreach (array_keys($endpoints) as $route) {
        if (strpos($route, '/wp/v2/users') === 0) {
            unset($endpoints[$route]);
        }
    }

    return $endpoints;
});

// Return 404 for author archives, including ?author=1 lookups. Runs before redirect_canonical, which would leak the username.
add_action('template_redirect', function () {
    if (is_author() || isset($_GET['author'])) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
    }
}, 1);

// Drop the users sitemap from core sitemaps.
add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    return $name === 'users' ? false : $provider;
}, 10, 2);
