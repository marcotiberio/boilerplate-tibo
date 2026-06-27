<?php

/**
 * Shared configuration + helpers for the Program Entry feature.
 *
 * Single source of truth for the submission fields so the public form,
 * the ACF field group and the REST handler never drift apart.
 * Field spec mirrors the client's intake sheet (German labels).
 */

namespace Flynt\ProgramEntry;

use Flynt\Utils\Options;

const POST_TYPE = 'program_entry';
const NONCE_ACTION = 'looptopia_program_entry';

/**
 * Choice lists for every select/checkbox/radio field. Keys are stored,
 * labels are displayed. Single source for form, ACF and REST validation.
 */
function getConfig()
{
    return [
        // Thema / Ziele — multiple choice
        'goals' => [
            'werterhalt'      => __('Werterhalt in der Praxis', 'flynt'),
            'instrumente'     => __('Instrumente & Hilfsmittel für die Transformation', 'flynt'),
            'geschaeftsmodelle' => __('Zirkuläre Geschäftsmodelle & Innovation', 'flynt'),
            'finanzierung'    => __('Finanzierung & Skalierung', 'flynt'),
            'spielregeln'     => __('Neue Spielregeln für eine kreislauffähige Zukunft', 'flynt'),
            'politik'         => __('Politische Hebel & Rahmenbedingungen für Circular Economy', 'flynt'),
            'kooperation'     => __('Kooperation, Beteiligung & Wissensaufbau', 'flynt'),
            'lifestyle'       => __('Circular Lifestyle', 'flynt'),
            'orte'            => __('Alltägliche Orte, um zirkuläre Lösungen auszuprobieren', 'flynt'),
            'nachbarschaft'   => __('Nachbarschaft, Teilhabe & soziale Innovation', 'flynt'),
        ],
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
        // Zielgruppe — multiple choice
        'audiences' => [
            'fach'        => __('Fachveranstaltung', 'flynt'),
            'unternehmen' => __('Unternehmen', 'flynt'),
            'wissenschaft' => __('Wissenschaft & Bildung', 'flynt'),
            'politik'     => __('Politik & Verwaltung', 'flynt'),
            'freizeit'    => __('Freizeit', 'flynt'),
            'erwachsene'  => __('Erwachsene', 'flynt'),
            'senioren'    => __('Senior:innen', 'flynt'),
            'jugend'      => __('Jugendliche', 'flynt'),
            'familien'    => __('Familien & Kinder', 'flynt'),
        ],
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
            'online' => __('Online', 'flynt'),
        ],
        // Anmeldung erforderlich? — single choice (conditional link)
        'registration' => [
            'offen'      => __('Offenes Format', 'flynt'),
            'anmeldung'  => __('Mit Anmeldung', 'flynt'),
        ],
        // Kosten? — single choice (conditional price + link)
        'costs' => [
            'nein' => __('Nein', 'flynt'),
            'ja'   => __('Ja', 'flynt'),
        ],
        // Wann? — either/or radio
        'dateMode' => [
            'flexibel' => __('Wir sind zeitlich flexibel, macht uns gerne ein Angebot', 'flynt'),
            'wunsch'   => __('Wir haben einen Wunschtermin', 'flynt'),
        ],
        // Wo? — either/or radio
        'locationMode' => [
            'suche' => __('Wir haben keinen passenden Veranstaltungsort und freuen uns über Tipps und/oder Vernetzung', 'flynt'),
            'eigen' => __('Wir haben einen passenden Veranstaltungsort', 'flynt'),
        ],
    ];
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
