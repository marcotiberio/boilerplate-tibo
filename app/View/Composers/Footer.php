<?php

namespace App\View\Composers;

/**
 * Footer View Composer
 *
 * Provides data to the footer partial.
 */

add_filter('sage/footer_data', function () {
    $data = [
        'footer_logo' => null,
        'footer_copyrights' => '',
        'footer_columns' => [],
        'newsletter_link' => null,
    ];

    if (function_exists('get_field')) {
        $data['footer_logo'] = get_field('navigation_footer_logo', 'option');
        $data['footer_copyrights'] = get_field('navigation_footer_copyrights', 'option');
        $data['footer_columns'] = get_field('navigation_footer_columns', 'option') ?: [];
        $data['newsletter_link'] = get_field('navigation_footer_newsletter_link', 'option');
    }

    return $data;
});
