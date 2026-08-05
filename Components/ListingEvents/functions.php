<?php

namespace Flynt\Components\ListingEvents;

use Flynt\Event;
use Flynt\Utils\Asset;

function getACFLayout()
{
    return [
        'name' => 'listingEvents',
        'label' => __('Event Listing', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'default_value' => __('Programm', 'flynt'),
            ],
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'required' => 0,
            ],
        ],
    ];
}

/**
 * One list row per published event. Everything the row renders is resolved
 * here; `filters` holds the stable keys the client side matches against —
 * see index.twig (Alpine) for the filtering itself.
 */
function buildEntry($post, array $config)
{
    $dates = array_values((array) (get_field('dates', $post->ID) ?: []));
    $programTypes = (array) (get_field('programTypes', $post->ID) ?: []);
    $sectors = (array) (get_field('sectors', $post->ID) ?: []);
    $audiences = (array) (get_field('audiences', $post->ID) ?: []);
    $accessibility = (array) (get_field('accessibility', $post->ID) ?: []);
    $accessible = Event\isAccessible($accessibility);

    // Badge glyph follows the first selected program type, as on the map pins.
    $icons = Event\getProgramTypeIcons();
    $iconFile = $icons[reset($programTypes) ?: ''] ?? 'team-assignment.png';

    $imageId = get_post_thumbnail_id($post) ?: 0;
    if (!$imageId) {
        $featured = get_field('featuredImage', $post->ID);
        $imageId = is_array($featured) ? ($featured['ID'] ?? 0) : (int) $featured;
    }

    $schedule = Event\getScheduleRows($post->ID);

    return [
        'id'               => $post->ID,
        'title'            => get_the_title($post),
        'link'             => get_permalink($post),
        'image'            => $imageId ? wp_get_attachment_image_url($imageId, 'medium_large') : '',
        'imageAlt'         => $imageId ? (string) get_post_meta($imageId, '_wp_attachment_image_alt', true) : '',
        'icon'             => Asset::requireUrl('assets/icons/event/' . $iconFile),
        'schedule'         => $schedule,
        'programTypeLabel' => $config['programTypes'][reset($programTypes) ?: ''] ?? '',
        'sectorLabels'     => array_values(array_filter(array_map(fn ($key) => $config['sectors'][$key] ?? '', $sectors))),
        'org'              => (string) (get_field('orgName', $post->ID) ?: ''),
        'addressLines'     => buildAddressLines($post->ID),
        'family'           => in_array('familien', $audiences, true),
        'accessible'       => $accessible,
        'sortKey'          => buildSortKey($dates, $schedule),
        'filters'          => [
            'dates'      => $dates,
            'audiences'  => array_values($audiences),
            'sectors'    => array_values($sectors),
            'format'     => (string) (get_field('format', $post->ID) ?: ''),
            'district'   => (string) (get_field('district', $post->ID) ?: ''),
            'language'   => (string) (get_field('language', $post->ID) ?: ''),
            'accessible' => $accessible,
        ],
    ];
}

/**
 * Venue address as printed lines. Berlin is implied by the feature (the
 * geocoder appends it too), so only street and postal code are stored.
 */
function buildAddressLines($postId)
{
    $street = trim((string) (get_field('street', $postId) ?: ''));
    $postalCode = trim((string) (get_field('postalCode', $postId) ?: ''));

    return array_values(array_filter([
        $street,
        $postalCode ? $postalCode . ' ' . __('Berlin', 'flynt') : '',
    ]));
}

/**
 * Chronological sort key: earliest day, then earliest start time. Entries
 * without a day or time sort last rather than jumping to the top.
 */
function buildSortKey(array $dates, array $schedule)
{
    $days = array_values(array_filter($dates));
    sort($days);

    $starts = array_values(array_filter(array_column($schedule, 'start')));
    sort($starts);

    return ($days[0] ?? '9999-12-31') . ' ' . ($starts[0] ?? '99:99');
}

/**
 * Every value used by at least one entry for a given filter key, so controls
 * that would match nothing are never rendered.
 */
function usedValues(array $entries, $key)
{
    $used = [];
    foreach (array_column($entries, 'filters') as $filters) {
        foreach ((array) ($filters[$key] ?? []) as $value) {
            if ($value !== '') {
                $used[$value] = true;
            }
        }
    }
    return $used;
}

add_filter('Flynt/addComponentData?name=ListingEvents', function ($data) {
    $config = Event\getConfig();

    $posts = get_posts([
        'post_type'      => Event\POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ]);

    $entries = array_map(fn ($post) => buildEntry($post, $config), $posts);
    usort($entries, fn ($a, $b) => strcmp($a['sortKey'], $b['sortKey']));

    // Bezirk and Sprache only list what the program actually offers, so a
    // German-only program shows a single "DE" button as in the design.
    $languages = [];
    foreach (array_keys(usedValues($entries, 'language')) as $key) {
        $languages[] = [
            'key'   => $key,
            'label' => $config['languages'][$key] ?? $key,
            'short' => Event\languageShortLabel($key),
        ];
    }

    $data['entries'] = $entries;
    // Keyed by post ID: the rows are rendered server side and only ask the
    // client side whether their own ID currently matches. Cast to an object so
    // the lookup by ID works whatever the IDs happen to be, while the value
    // lists below it stay JSON arrays.
    $data['filterData'] = wp_json_encode((object) array_column($entries, 'filters', 'id'));
    $data['days'] = Event\getDays();
    $data['audienceGroups'] = $config['audienceGroups'];
    $data['sectors'] = $config['sectors'];
    $data['formats'] = $config['format'];
    $data['districts'] = array_intersect_key($config['districts'], usedValues($entries, 'district'));
    $data['languages'] = $languages;
    $data['icons'] = [
        'family'        => Asset::requireUrl('assets/icons/event/family.png'),
        'accessibility' => Asset::requireUrl('assets/icons/event/accessibility.png'),
    ];

    return $data;
});
