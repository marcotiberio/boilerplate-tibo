<?php

/**
 * Shared configuration + helpers for the Program Entry feature.
 *
 * Single source of truth for the submission fields so the public form,
 * the ACF field group and the REST handler never drift apart.
 */

namespace Flynt\ProgramEntry;

use Flynt\Utils\Options;

const POST_TYPE = 'program_entry';
const NONCE_ACTION = 'looptopia_program_entry';

/**
 * Built-in fallback choices, used until the client fills the Theme Options
 * lists (and before `acf/init`, when options can't be read yet).
 */
function getDefaults()
{
    return [
        'categories' => [
            'workshop'    => __('Workshop', 'flynt'),
            'performance' => __('Performance', 'flynt'),
            'exhibition'  => __('Exhibition', 'flynt'),
            'talk'        => __('Talk', 'flynt'),
        ],
        'themes' => [
            'music'          => __('Music', 'flynt'),
            'art'            => __('Art', 'flynt'),
            'tech'           => __('Technology', 'flynt'),
            'community'      => __('Community', 'flynt'),
            'sustainability' => __('Sustainability', 'flynt'),
        ],
    ];
}

/**
 * Single source of truth for the choice lists used by the single-choice
 * (radio) and multiple-choice (checkbox) fields. Read from Theme Options so
 * the public form, the CPT review screen and the REST validation always agree.
 * Keys are stored, labels are displayed.
 */
function getConfig()
{
    $defaults = getDefaults();

    // Options live behind ACF; before acf/init we can only use the defaults.
    if (!did_action('acf/init')) {
        return $defaults;
    }

    return [
        'categories' => optionRowsToChoices(Options::getGlobal('ProgramEntry', 'categories'), $defaults['categories']),
        'themes'     => optionRowsToChoices(Options::getGlobal('ProgramEntry', 'themes'), $defaults['themes']),
    ];
}

/**
 * Turn an ACF repeater value ([['value' => , 'label' => ], ...]) into an
 * ACF-style choices map ['value' => 'label']. Falls back to $default when the
 * option is empty so the form is never left without options.
 */
function optionRowsToChoices($rows, $default)
{
    if (empty($rows) || !is_array($rows)) {
        return $default;
    }

    $choices = [];
    foreach ($rows as $row) {
        $value = sanitize_key($row['value'] ?? '');
        $label = trim((string) ($row['label'] ?? ''));
        if ($value !== '' && $label !== '') {
            $choices[$value] = $label;
        }
    }

    return $choices ?: $default;
}

/**
 * Geocode a free-text address into coordinates via the Google Geocoding API.
 * Reuses the key configured for the ACF Google Map field (Theme Options).
 * Returns null on any failure so callers can store the entry without a pin.
 *
 * @return array{lat: float, lng: float, formatted: string}|null
 */
function geocodeAddress($address)
{
    $address = trim((string) $address);
    if ($address === '') {
        return null;
    }

    $apiKey = Options::getGlobal('Acf', 'googleMapsApiKey');
    if (empty($apiKey)) {
        return null;
    }

    // add_query_arg url-encodes values, so pass the raw address.
    $url = add_query_arg([
        'address' => $address,
        'key'     => $apiKey,
    ], 'https://maps.googleapis.com/maps/api/geocode/json');

    $response = wp_remote_get($url, ['timeout' => 8]);
    if (is_wp_error($response)) {
        return null;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($body['results'][0]['geometry']['location'])) {
        return null;
    }

    $location = $body['results'][0]['geometry']['location'];

    return [
        'lat'       => (float) $location['lat'],
        'lng'       => (float) $location['lng'],
        'formatted' => $body['results'][0]['formatted_address'] ?? $address,
    ];
}

/**
 * Re-geocode when an editor saves an entry with an address but no pin yet.
 * Lets the client paste an address in wp-admin and get a marker automatically,
 * while still being able to drag the pin manually afterwards.
 */
add_action('acf/save_post', function ($postId) {
    if (get_post_type($postId) !== POST_TYPE) {
        return;
    }

    $address = get_field('address', $postId);
    $location = get_field('location', $postId);

    if (empty($address) || !empty($location['lat'])) {
        return;
    }

    $geo = geocodeAddress($address);
    if ($geo) {
        update_field('location', [
            'address' => $geo['formatted'],
            'lat'     => $geo['lat'],
            'lng'     => $geo['lng'],
        ], $postId);
    }
}, 20);

/**
 * Editable choice lists under Theme Options → Program Entry.
 * Each row is a stable machine value plus a human label.
 */
$choiceRepeater = function ($name, $label, $buttonLabel) {
    return [
        'label' => $label,
        'name' => $name,
        'type' => 'repeater',
        'instructions' => __('Leave empty to use the built-in defaults. The Value is stored with each entry — set it once and don’t change it afterwards.', 'flynt'),
        'layout' => 'table',
        'button_label' => $buttonLabel,
        'sub_fields' => [
            [
                'label' => __('Value', 'flynt'),
                'name' => 'value',
                'type' => 'text',
                'instructions' => __('Lowercase key, e.g. "workshop".', 'flynt'),
                'required' => 1,
                'wrapper' => ['width' => 40],
            ],
            [
                'label' => __('Label', 'flynt'),
                'name' => 'label',
                'type' => 'text',
                'required' => 1,
                'wrapper' => ['width' => 60],
            ],
        ],
    ];
};

Options::addGlobal('ProgramEntry', [
    $choiceRepeater('categories', __('Categories (single choice)', 'flynt'), __('Add category', 'flynt')),
    $choiceRepeater('themes', __('Themes (multiple choice)', 'flynt'), __('Add theme', 'flynt')),
]);

/**
 * Populate the CPT radio/checkbox choices from the same source at render time.
 * Done via load_field (after acf/init) because the field group registers
 * before acf/init, when the options can't be read yet.
 */
add_filter('acf/load_field/key=field_programEntryDetails_category', function ($field) {
    $field['choices'] = getConfig()['categories'];
    return $field;
});

add_filter('acf/load_field/key=field_programEntryDetails_themes', function ($field) {
    $field['choices'] = getConfig()['themes'];
    return $field;
});
