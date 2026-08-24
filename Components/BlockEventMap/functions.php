<?php

namespace Flynt\Components\BlockEventMap;

use Flynt\Event;
use Flynt\Utils\Asset;

function getACFLayout()
{
    return [
        'name' => 'blockEventMap',
        'label' => __('Event Map', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'required' => 0,
            ],
            [
                'label' => __('Default centre (lat, lng)', 'flynt'),
                'instructions' => __('Map centre when no entries are visible, e.g. "52.5200, 13.4050" for Berlin.', 'flynt'),
                'name' => 'center',
                'type' => 'text',
                'default_value' => '52.5200, 13.4050',
                'wrapper' => ['width' => 33],
            ],
            [
                'label' => __('Default zoom', 'flynt'),
                'name' => 'zoom',
                'type' => 'number',
                'default_value' => 12,
                'min' => 1,
                'max' => 18,
                'wrapper' => ['width' => 33],
            ],
            [
                'label' => __('Map style', 'flynt'),
                'instructions' => __('“Hell” matches the design; “Standard” uses the classic OpenStreetMap tiles.', 'flynt'),
                'name' => 'mapStyle',
                'type' => 'select',
                'choices' => [
                    'light' => __('Hell', 'flynt'),
                    'osm' => __('Standard', 'flynt'),
                ],
                'default_value' => 'light',
                'wrapper' => ['width' => 33],
            ],
        ],
    ];
}

/**
 * Tile sources. The light basemap matches the muted design; both are
 * OpenStreetMap data and carry the attribution their terms require.
 */
function getTileSources()
{
    return [
        'light' => [
            'url' => 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
            'attribution' => '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        ],
        'osm' => [
            'url' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'attribution' => '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        ],
    ];
}

/**
 * One map entry per published event that has a pin. Everything the overlay
 * card and the filter bar need is precomputed here, so the client side only
 * filters and renders — see index.twig (Alpine) and script.js (Leaflet).
 */
function buildEntry($post, array $config)
{
    $location = get_field('location', $post->ID);
    if (empty($location['lat']) || empty($location['lng'])) {
        return null;
    }

    $dates = (array) (get_field('dates', $post->ID) ?: []);
    $programTypes = (array) (get_field('programTypes', $post->ID) ?: []);
    $sectors = (array) (get_field('sectors', $post->ID) ?: []);
    $audiences = (array) (get_field('audiences', $post->ID) ?: []);
    $accessibility = (array) (get_field('accessibility', $post->ID) ?: []);
    // Multiple choice; legacy entries stored a single key, hence the cast.
    $languages = array_values(array_filter((array) (get_field('language', $post->ID) ?: [])));

    // Pin glyph follows the entry's format.
    $iconFile = Event\getFormatIcon($post->ID);

    $imageId = get_post_thumbnail_id($post) ?: 0;
    if (!$imageId) {
        $featured = get_field('featuredImage', $post->ID);
        $imageId = is_array($featured) ? ($featured['ID'] ?? 0) : (int) $featured;
    }

    return [
        'id'               => $post->ID,
        'title'            => get_the_title($post),
        'link'             => get_permalink($post),
        'lat'              => (float) $location['lat'],
        'lng'              => (float) $location['lng'],
        'image'            => $imageId ? wp_get_attachment_image_url($imageId, 'medium_large') : '',
        'org'              => (string) (get_field('orgName', $post->ID) ?: ''),
        'schedule'         => Event\getScheduleRows($post->ID),
        'dates'            => array_values($dates),
        'programTypeLabel' => $config['programTypes'][reset($programTypes) ?: ''] ?? '',
        'sectorLabels'     => array_values(array_filter(array_map(fn ($key) => $config['sectors'][$key] ?? '', $sectors))),
        'audiences'        => array_values($audiences),
        'format'           => (string) (get_field('format', $post->ID) ?: ''),
        'languages'        => $languages,
        'languageLabel'    => implode(', ', array_filter(array_map(fn ($key) => $config['languages'][$key] ?? '', $languages))),
        'accessible'       => Event\isAccessible($accessibility),
        'family'           => in_array('familien', $audiences, true),
        'icon'             => Asset::requireUrl('assets/icons/event/' . $iconFile),
    ];
}

add_filter('Flynt/addComponentData?name=BlockEventMap', function ($data) {
    $config = Event\getConfig();

    $posts = get_posts([
        'post_type'      => Event\POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => [
            ['key' => 'location', 'compare' => 'EXISTS'],
        ],
    ]);

    $entries = array_values(array_filter(array_map(fn ($post) => buildEntry($post, $config), $posts)));

    // Language pills only list what the program actually offers, so a
    // German-only program shows a single "DE" button as in the design.
    $usedLanguages = array_unique(array_merge([], ...array_column($entries, 'languages')));
    $languages = [];
    foreach ($config['languages'] as $key => $label) {
        if (in_array($key, $usedLanguages, true)) {
            $languages[] = [
                'key'   => $key,
                'label' => $label,
                'short' => Event\languageShortLabel($key),
            ];
        }
    }

    $tiles = getTileSources();

    $data['entries'] = $entries;
    $data['days'] = Event\getDays();
    $data['audienceGroups'] = $config['audienceGroups'];
    $data['formats'] = $config['format'];
    $data['languages'] = $languages;
    $data['tiles'] = $tiles[$data['mapStyle'] ?? 'light'] ?? $tiles['light'];
    $data['cardIcons'] = [
        'family'     => Asset::requireUrl('assets/icons/event/family.png'),
        'wheelchair' => Asset::requireUrl('assets/icons/event/accessibility.png'),
    ];

    return $data;
});
