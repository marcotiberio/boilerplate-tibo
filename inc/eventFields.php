<?php

/**
 * Shared configuration + helpers for the Event feature.
 *
 * Single source of truth for the submission fields so the public form,
 * the ACF field group and the REST handler never drift apart.
 * Field spec mirrors the client's intake sheet (German labels).
 */

namespace Flynt\Event;

use Flynt\Utils\Options;

const POST_TYPE = 'event';
const NONCE_ACTION = 'looptopia_event';

/**
 * Choice lists for every select/checkbox/radio field. Keys are stored,
 * labels are displayed. Single source for form, ACF and REST validation.
 */
function getConfig()
{
    return [
        // Thema / Ziele — multiple choice, grouped under non-selectable
        // category headings. Flat key=>label map for ACF + REST validation.
        'goalGroups' => getGoalGroups(),
        'goals' => flattenGroups(getGoalGroups()),
        // Sektor — multiple choice
        'sectors' => [
            'ernaehrung'    => __('Ernährung', 'flynt'),
            'bauen'         => __('Bauen & Wohnen', 'flynt'),
            'mobilitaet'    => __('Mobilität & Logistik', 'flynt'),
            'digital'       => __('Digitalwirtschaft & Technologie', 'flynt'),
            'kunst'         => __('Kunst & Kreativwirtschaft', 'flynt'),
            'produktion'    => __('Produktion & Industrie', 'flynt'),
            'handel'        => __('Handel & Konsumgüter', 'flynt'),
            'wissenschaft'  => __('Wissenschaft, Forschung & Bildung', 'flynt'),
            'tourismus'     => __('Tourismus, Freizeit & Veranstaltungen', 'flynt'),
        ],
        // Art des Programmpunkts — multiple choice
        'programTypes' => [
            'workshop'   => __('Mitmachaktion / Workshop', 'flynt'),
            'reparatur'  => __('Reparaturangebot / Reparatur Workshop', 'flynt'),
            'panel'      => __('Panel / Vortrag', 'flynt'),
            'kunst'      => __('Kunst / Kultur (Ausstellung, Performance, Tanz, Musik, Film, Lesung, Podcast)', 'flynt'),
            'community'  => __('Community / Networking Event', 'flynt'),
            'openhouse'  => __('Open House / Behind the Scene', 'flynt'),
            'tour'       => __('Tour / Walk / Stadt-Erlebnis', 'flynt'),
        ],
        // Zielgruppe — multiple choice, grouped under non-selectable
        // category headings. Flat key=>label map for ACF + REST validation.
        'audienceGroups' => getAudienceGroups(),
        'audiences' => flattenGroups(getAudienceGroups()),
        // Barrierefreiheit — multiple choice
        'accessibility' => [
            'eingang'   => __('Eingang barrierefrei', 'flynt'),
            'wc'        => __('WC barrierefrei', 'flynt'),
            'komplett'  => __('Komplett barrierefrei', 'flynt'),
            'keine'     => __('Nicht barrierefrei', 'flynt'),
        ],
        // Format — single choice
        'format' => [
            'vorort' => __('Vor Ort', 'flynt'),
            'hybrid' => __('Hybrid', 'flynt'),
        ],
        // Anmeldung erforderlich? — single choice (conditional link)
        'registration' => [
            'offen'      => __('Offenes Format', 'flynt'),
            'anmeldung'  => __('Mit Anmeldung', 'flynt'),
        ],
        // Sprache der Veranstaltung — single choice (German language names)
        'languages' => [
            'Deutsch'        => __('Deutsch', 'flynt'),
            'Englisch'       => __('Englisch', 'flynt'),
            'Türkisch'       => __('Türkisch', 'flynt'),
            'Arabisch'       => __('Arabisch', 'flynt'),
            'Französisch'    => __('Französisch', 'flynt'),
            'Spanisch'       => __('Spanisch', 'flynt'),
            'Italienisch'    => __('Italienisch', 'flynt'),
            'Portugiesisch'  => __('Portugiesisch', 'flynt'),
            'Polnisch'       => __('Polnisch', 'flynt'),
            'Russisch'       => __('Russisch', 'flynt'),
            'Ukrainisch'     => __('Ukrainisch', 'flynt'),
            'Niederländisch' => __('Niederländisch', 'flynt'),
            'Griechisch'     => __('Griechisch', 'flynt'),
            'Chinesisch'     => __('Chinesisch', 'flynt'),
            'Japanisch'      => __('Japanisch', 'flynt'),
            'Koreanisch'     => __('Koreanisch', 'flynt'),
            'Vietnamesisch'  => __('Vietnamesisch', 'flynt'),
            'Hindi'          => __('Hindi', 'flynt'),
            'Persisch'       => __('Persisch', 'flynt'),
            'Hebräisch'      => __('Hebräisch', 'flynt'),
            'Schwedisch'     => __('Schwedisch', 'flynt'),
            'Dänisch'        => __('Dänisch', 'flynt'),
            'Norwegisch'     => __('Norwegisch', 'flynt'),
            'Finnisch'       => __('Finnisch', 'flynt'),
            'Tschechisch'    => __('Tschechisch', 'flynt'),
            'Rumänisch'      => __('Rumänisch', 'flynt'),
            'Ungarisch'      => __('Ungarisch', 'flynt'),
            'Bulgarisch'     => __('Bulgarisch', 'flynt'),
            'Kroatisch'      => __('Kroatisch', 'flynt'),
            'Serbisch'       => __('Serbisch', 'flynt'),
        ],
        // Kosten? — single choice (conditional price + link)
        'costs' => [
            'nein' => __('Nein', 'flynt'),
            'ja'   => __('Ja', 'flynt'),
        ],
        // Wann? — event runs on 14. and/or 15.11.26, both selectable.
        // Keys are ISO dates (stable for storage); labels are display-only.
        'dates' => [
            '2026-11-14' => __('14.11.26', 'flynt'),
            '2026-11-15' => __('15.11.26', 'flynt'),
        ],
        // Wo? — either/or radio
        'locationMode' => [
            'suche' => __('Wir haben keinen passenden Veranstaltungsort und freuen uns über Tipps und/oder Vernetzung', 'flynt'),
            'eigen' => __('Wir haben einen passenden Veranstaltungsort', 'flynt'),
        ],
    ];
}

/**
 * Thema / Ziele grouped under non-selectable category headings.
 * Only the choices are selectable; the group labels are display-only.
 */
function getGoalGroups()
{
    return [
        [
            'label' => __('Kreislaufwirtschaft, die erlebbar ist', 'flynt'),
            'choices' => [
                'orte'          => __('Alltägliche Orte, um zirkuläre Lösungen auszuprobieren', 'flynt'),
                'nachbarschaft' => __('Nachbarschaft, Teilhabe & soziale Innovation', 'flynt'),
            ],
        ],
        [
            'label' => __('Kreislaufwirtschaft, die sich lohnt', 'flynt'),
            'choices' => [
                'instrumente'       => __('Instrumente & Hilfsmittel für die Transformation', 'flynt'),
                'geschaeftsmodelle' => __('Zirkuläre Geschäftsmodelle & Innovation', 'flynt'),
                'finanzierung'      => __('Finanzierung & Skalierung', 'flynt'),
            ],
        ],
        [
            'label' => __('Kreislaufwirtschaft, die Zukunft gestaltet', 'flynt'),
            'choices' => [
                'politik'     => __('Politische Hebel & Rahmenbedingungen für Circular Economy', 'flynt'),
                'kooperation' => __('Kooperation, Beteiligung & Wissensaufbau', 'flynt'),
            ],
        ],
    ];
}

/**
 * Zielgruppe grouped under non-selectable category headings.
 * Only the choices are selectable; the group labels are display-only.
 */
function getAudienceGroups()
{
    return [
        [
            'label' => __('Fachveranstaltung', 'flynt'),
            'choices' => [
                'unternehmen'  => __('Unternehmen', 'flynt'),
                'wissenschaft' => __('Wissenschaft & Bildung', 'flynt'),
                'politik'      => __('Politik & Verwaltung', 'flynt'),
            ],
        ],
        [
            'label' => __('Freizeit', 'flynt'),
            'choices' => [
                'erwachsene' => __('Erwachsene', 'flynt'),
                'senioren'   => __('Senior:innen', 'flynt'),
                'jugend'     => __('Jugendliche', 'flynt'),
                'familien'   => __('Familien & Kinder', 'flynt'),
            ],
        ],
    ];
}

/**
 * Merge a grouped choice structure into a single flat key=>label map.
 */
function flattenGroups(array $groups)
{
    $flat = [];
    foreach ($groups as $group) {
        $flat += $group['choices'];
    }
    return $flat;
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
 * Compose a geocodable address from the submitted street + postal code.
 * Berlin is appended to keep results within the city.
 */
function composeAddress($street, $postalCode)
{
    $parts = array_filter([trim((string) $street), trim((string) $postalCode), 'Berlin, Germany']);
    return implode(', ', $parts);
}

/**
 * Re-geocode when an editor saves an entry with an address but no pin yet.
 * Lets the client adjust street/PLZ in wp-admin and get a marker automatically,
 * while still being able to drag the pin manually afterwards.
 */
add_action('acf/save_post', function ($postId) {
    if (get_post_type($postId) !== POST_TYPE) {
        return;
    }

    $location = get_field('location', $postId);
    if (!empty($location['lat'])) {
        return;
    }

    $address = composeAddress(get_field('street', $postId), get_field('postalCode', $postId));
    $geo = geocodeAddress($address);
    if ($geo) {
        update_field('location', [
            'address' => $geo['formatted'],
            'lat'     => $geo['lat'],
            'lng'     => $geo['lng'],
        ], $postId);
    }
}, 20);
