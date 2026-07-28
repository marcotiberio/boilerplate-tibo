<?php

/**
 * Shared configuration + helpers for the Event feature.
 *
 * Single source of truth for the submission fields so the public form,
 * the ACF field group and the REST handler never drift apart.
 * Field spec mirrors the client's intake sheet (German labels).
 *
 * Choice labels are client-editable under "Global Options → Event";
 * the stored keys are hardcoded here and must never change so that
 * already-sent submissions stay compatible.
 */

namespace Flynt\Event;

use Flynt\Utils\Options;

const POST_TYPE = 'event';
const NONCE_ACTION = 'looptopia_event';
const LABEL_OPTIONS_SCOPE = 'EventChoiceLabels';

/**
 * Choice lists for every select/checkbox/radio field. Keys are stored,
 * labels are displayed. Single source for form, ACF and REST validation.
 *
 * Labels can be renamed by the client under "Global Options → Event";
 * the keys are fixed here and never change, so submissions sent with
 * the old wording stay fully compatible.
 */
function getConfig()
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    $resolved = applyLabelOverrides(getDefaultConfig(), getLabelOverrides());

    // Options are only readable once ACF is initialised. Cache after that;
    // earlier callers just get the built-in default labels (same keys).
    if (did_action('acf/init')) {
        $config = $resolved;
    }

    return $resolved;
}

/**
 * Built-in defaults: the full set of stored keys with their original labels.
 */
function getDefaultConfig()
{
    return [
        // Thema / Ziele — multiple choice, grouped under non-selectable
        // category headings. Flat key=>label map for ACF + REST validation.
        'goalGroups' => getDefaultGoalGroups(),
        'goals' => flattenGroups(getDefaultGoalGroups()),
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
        'audienceGroups' => getDefaultAudienceGroups(),
        'audiences' => flattenGroups(getDefaultAudienceGroups()),
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
            'suche' => __('Ich habe keinen  passenden Veranstaltungsort und freue mich über Tipps und/oder Vernetzung', 'flynt'),
            'eigen' => __('Ich habe einen passenden Veranstaltungsort', 'flynt'),
        ],
    ];
}

/**
 * Thema / Ziele grouped under non-selectable category headings.
 * Only the choices are selectable; the group labels are display-only.
 * Array keys are the stable group slugs used for the label options.
 */
function getDefaultGoalGroups()
{
    return [
        'erlebbar' => [
            'label' => __('Kreislaufwirtschaft, die erlebbar ist', 'flynt'),
            'choices' => [
                'orte'          => __('Alltägliche Orte, um zirkuläre Lösungen auszuprobieren', 'flynt'),
                'nachbarschaft' => __('Nachbarschaft, Teilhabe & soziale Innovation', 'flynt'),
            ],
        ],
        'lohnt' => [
            'label' => __('Kreislaufwirtschaft, die sich lohnt', 'flynt'),
            'choices' => [
                'instrumente'       => __('Instrumente & Hilfsmittel für die Transformation', 'flynt'),
                'geschaeftsmodelle' => __('Zirkuläre Geschäftsmodelle & Innovation', 'flynt'),
                'finanzierung'      => __('Finanzierung & Skalierung', 'flynt'),
            ],
        ],
        'zukunft' => [
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
 * Array keys are the stable group slugs used for the label options.
 */
function getDefaultAudienceGroups()
{
    return [
        'fach' => [
            'label' => __('Fachveranstaltung', 'flynt'),
            'choices' => [
                'unternehmen'  => __('Unternehmen', 'flynt'),
                'wissenschaft' => __('Wissenschaft & Bildung', 'flynt'),
                'politik'      => __('Politik & Verwaltung', 'flynt'),
            ],
        ],
        'freizeit' => [
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
 * Flat choice lists whose labels are client-editable (grouped lists are
 * handled separately). Shared by the option fields and the overlay.
 */
const FLAT_LABEL_LISTS = ['sectors', 'programTypes', 'accessibility', 'registration', 'costs', 'format', 'dates', 'locationMode'];

/**
 * Option field name for a choice key, e.g. sectors/ernaehrung →
 * `sectors_ernaehrung`. Hyphens are stripped so ISO date keys stay valid
 * ACF field names ('2026-11-14' → `dates_20261114`).
 */
function labelOptionName($list, $key)
{
    return $list . '_' . str_replace('-', '', $key);
}

/**
 * Client-saved label texts, keyed by option field name. Empty fields fall
 * back to the defaults. Returns [] before ACF is ready.
 */
function getLabelOverrides()
{
    if (!did_action('acf/init')) {
        return [];
    }

    $saved = Options::getGlobal(LABEL_OPTIONS_SCOPE);
    if (!is_array($saved)) {
        return [];
    }

    return array_filter($saved, fn ($value) => is_string($value) && trim($value) !== '');
}

/**
 * Replace default labels with the client-edited ones. Keys are never
 * touched — only the display text changes.
 */
function applyLabelOverrides(array $config, array $overrides)
{
    if (!$overrides) {
        return $config;
    }

    foreach (FLAT_LABEL_LISTS as $list) {
        foreach ($config[$list] as $key => $label) {
            $option = labelOptionName($list, $key);
            if (isset($overrides[$option])) {
                $config[$list][$key] = $overrides[$option];
            }
        }
    }

    foreach (['goalGroups' => 'goals', 'audienceGroups' => 'audiences'] as $groupList => $flatList) {
        foreach ($config[$groupList] as $slug => $group) {
            $groupOption = $flatList . 'Group_' . $slug;
            if (isset($overrides[$groupOption])) {
                $config[$groupList][$slug]['label'] = $overrides[$groupOption];
            }
            foreach ($group['choices'] as $key => $label) {
                $option = labelOptionName($flatList, $key);
                if (isset($overrides[$option])) {
                    $config[$groupList][$slug]['choices'][$key] = $overrides[$option];
                }
            }
        }
        $config[$flatList] = flattenGroups($config[$groupList]);
    }

    return $config;
}

/**
 * Section headings for the public form. Keys are fixed and map to the
 * `<fieldset>` blocks in Components/FormEvent/index.twig; the title and intro
 * are client-editable under "Global Options → Event". Intros default to empty,
 * so no intro is shown until one is entered.
 */
function getDefaultSections()
{
    return [
        'org'      => ['title' => __('Organisation', 'flynt'), 'intro' => ''],
        'offer'    => ['title' => __('Angebot', 'flynt'), 'intro' => ''],
        'details'  => ['title' => __('Details zum Angebot', 'flynt'), 'intro' => ''],
        'audience' => ['title' => __('Zielgruppe', 'flynt'), 'intro' => ''],
        'event'    => ['title' => __('Veranstaltung', 'flynt'), 'intro' => ''],
        'consent'  => ['title' => __('Anmeldeformular absenden', 'flynt'), 'intro' => ''],
    ];
}

/**
 * Option field name for a section part, e.g. org/title → `section_org_title`.
 */
function sectionOptionName($key, $part)
{
    return 'section_' . $key . '_' . $part;
}

/**
 * Section headings with the client-edited title/intro applied, falling back to
 * the defaults for any blank field. Shares the label-override scope, so the
 * single "Global Options → Event" page drives both choice labels and headings.
 */
function getSections()
{
    $overrides = getLabelOverrides();
    $sections = getDefaultSections();

    foreach ($sections as $key => $section) {
        foreach (['title', 'intro'] as $part) {
            $option = sectionOptionName($key, $part);
            if (isset($overrides[$option])) {
                $sections[$key][$part] = $overrides[$option];
            }
        }
    }

    return $sections;
}

/**
 * One text field per choice label for the "Global Options → Event" page.
 * Fields are generated from the defaults so the two can never drift; the
 * default label doubles as field label and placeholder.
 */
function getLabelOptionFields()
{
    $config = getDefaultConfig();

    $tab = fn ($label, $name) => [
        'label' => $label,
        'name' => $name,
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ];
    $text = fn ($name, $default, $width = 50, $instructions = '') => [
        'label' => $default,
        'name' => $name,
        'type' => 'text',
        'instructions' => $instructions,
        'placeholder' => $default,
        'wrapper' => ['width' => $width],
    ];

    $fields = [
        [
            'label' => __('Hinweis', 'flynt'),
            'name' => 'labelsInfo',
            'type' => 'message',
            'message' => __('Beschriftungen der Auswahlfelder — sichtbar im Anmeldeformular, im Backend und auf der Karte. Leere Felder verwenden die Standard-Beschriftung (grau angezeigt). Die intern gespeicherten Werte ändern sich nicht, bereits eingegangene Einsendungen bleiben vollständig kompatibel.', 'flynt'),
        ],
    ];

    // Section headings tab — title + optional intro for each form section.
    $fields[] = $tab(__('Sections', 'flynt'), 'sectionsTab');
    foreach (getDefaultSections() as $key => $section) {
        $fields[] = $text(sectionOptionName($key, 'title'), $section['title'], 100, __('Section heading', 'flynt'));
        $fields[] = [
            'label' => sprintf(__('%s — Intro', 'flynt'), $section['title']),
            'name' => sectionOptionName($key, 'intro'),
            'type' => 'wysiwyg',
            'tabs' => 'visual',
            'media_upload' => 0,
            'delay' => 1,
            'instructions' => __('Optional intro text shown below the heading.', 'flynt'),
        ];
    }

    $groupedTabs = [
        'goalGroups' => ['goals', __('Thema / Ziele', 'flynt')],
        'audienceGroups' => ['audiences', __('Zielgruppe', 'flynt')],
    ];
    foreach ($groupedTabs as $groupList => [$flatList, $tabLabel]) {
        $fields[] = $tab($tabLabel, $flatList . 'Tab');
        foreach ($config[$groupList] as $slug => $group) {
            $fields[] = $text($flatList . 'Group_' . $slug, $group['label'], 100, __('Gruppenüberschrift', 'flynt'));
            foreach ($group['choices'] as $key => $label) {
                $fields[] = $text(labelOptionName($flatList, $key), $label);
            }
        }
    }

    $flatTabs = [
        'sectors' => __('Sektor', 'flynt'),
        'programTypes' => __('Art des Programmpunkts', 'flynt'),
        'accessibility' => __('Barrierefreiheit', 'flynt'),
        'registration' => __('Anmeldung', 'flynt'),
        'costs' => __('Kosten', 'flynt'),
        'format' => __('Format', 'flynt'),
        'dates' => __('Termine', 'flynt'),
        'locationMode' => __('Veranstaltungsort', 'flynt'),
    ];
    foreach ($flatTabs as $list => $tabLabel) {
        $fields[] = $tab($tabLabel, $list . 'Tab');
        foreach ($config[$list] as $key => $label) {
            $fields[] = $text(labelOptionName($list, $key), $label, mb_strlen($label) > 60 ? 100 : 50);
        }
    }

    return $fields;
}

Options::addGlobal(LABEL_OPTIONS_SCOPE, getLabelOptionFields(), 'Event');

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
