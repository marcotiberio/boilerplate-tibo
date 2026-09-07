<?php

namespace Flynt\Acf;

use Flynt\Utils\Options;

add_filter('pre_http_request', function ($preempt, $args, $url) {
    if (strpos($url, 'https://www.youtube.com/oembed') !== false || strpos($url, 'https://vimeo.com/api/oembed') !== false) {
        $response = wp_cache_get($url, 'oembedCache');
        if (!empty($response)) {
            return $response;
        }
    }
    return false;
}, 10, 3);

add_filter('http_response', function ($response, $args, $url) {
    if (strpos($url, 'https://www.youtube.com/oembed') !== false || strpos($url, 'https://vimeo.com/api/oembed') !== false) {
        wp_cache_set($url, $response, 'oembedCache');
    }
    return $response;
}, 10, 3);

add_filter('acf/fields/google_map/api', function ($api) {
    $apiKey = Options::getGlobal('Acf', 'googleMapsApiKey');
    if ($apiKey) {
        $api['key'] = $apiKey;
    }
    return $api;
});

Options::addGlobal('Acf', [
    [
        'name' => 'googleMapsTab',
        'label' => __('Google Maps', 'flynt'),
        'type' => 'tab'
    ],
    [
        'name' => 'googleMapsApiKey',
        'label' => __('Google Maps Api Key', 'flynt'),
        'type' => 'text',
        'maxlength' => 100,
        'prepend' => '',
        'append' => '',
        'placeholder' => ''
    ]
]);

/**
 * Character limit for the link text of `link` fields.
 *
 * The link field has no native `maxlength` setting, and its title is typed into
 * the shared WordPress link modal rather than a per-field input. A custom
 * `maxlength` key on the field definition survives acf_validate_field(), so it
 * can be enforced here on save.
 *
 * Usage: add `'maxlength' => 25` to any field of type `link`.
 */
add_filter('acf/validate_value/type=link', function ($valid, $value, $field) {
    if ($valid !== true || empty($field['maxlength']) || empty($value['title'])) {
        return $valid;
    }

    $max = (int) $field['maxlength'];

    if (mb_strlen($value['title']) > $max) {
        return sprintf(
            /* translators: %d: maximum number of characters */
            __('Link text must be %d characters or less.', 'flynt'),
            $max
        );
    }

    return $valid;
}, 20, 3);

/**
 * Mirror the link `maxlength` onto the field wrapper as `data-maxlength`, so
 * assets/admin.js can cap typing in the link modal before the save happens.
 */
add_filter('acf/prepare_field/type=link', function ($field) {
    if (!empty($field['maxlength'])) {
        $field['data']['maxlength'] = (int) $field['maxlength'];
    }

    return $field;
});
