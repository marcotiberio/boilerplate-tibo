<?php

namespace App\View\Composers;

/**
 * Header View Composer
 *
 * Provides data to the header partial.
 * In Sage with Acorn, this would extend Roots\Acorn\View\Composer.
 * For now, we use a WordPress filter approach.
 */

add_filter('sage/header_data', function () {
    $logo_url = get_theme_mod('custom_header_logo')
        ?: get_theme_file_uri('resources/images/logo.svg');

    // Get CTA link from ACF options if available
    $cta_link = null;
    if (function_exists('get_field')) {
        $cta_link = get_field('navigation_main_cta_link', 'option');
    }

    return [
        'logo_url' => $logo_url,
        'cta_link' => $cta_link,
    ];
});
