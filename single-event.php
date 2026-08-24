<?php

use Timber\Timber;
use Flynt\Event;
use Flynt\Utils\Asset;

$context = Timber::context();
$post = $context['post'];

// Resolve stored choice keys to their human labels.
$config = Event\getConfig();

$mapLabels = function ($keys, $choices) {
    return array_map(function ($key) use ($choices) {
        return $choices[$key] ?? $key;
    }, (array) ($keys ?: []));
};
$singleLabel = function ($key, $choices) use ($post) {
    $value = $post->meta($key);
    return $choices[$value] ?? $value;
};

$context['labels'] = [
    'goals'         => $mapLabels($post->meta('goals'), $config['goals']),
    'sectors'       => $mapLabels($post->meta('sectors'), $config['sectors']),
    'programTypes'  => $mapLabels($post->meta('programTypes'), $config['programTypes']),
    'audiences'     => $mapLabels($post->meta('audiences'), $config['audiences']),
    'accessibility' => $mapLabels($post->meta('accessibility'), $config['accessibility']),
    'registration'  => $singleLabel('registration', $config['registration']),
    'costs'         => $singleLabel('costs', $config['costs']),
    'format'        => $singleLabel('format', $config['format']),
    'language'      => $mapLabels($post->meta('language'), $config['languages']),
    'dates'         => $mapLabels($post->meta('dates'), $config['dates']),
    'locationMode'  => $singleLabel('locationMode', $config['locationMode']),
];

/**
 * Icon set exported from the design (Streamline Ultimate).
 * Passed as URLs because the PNGs are not part of a Vite entry.
 */
$icon = function ($file) {
    return Asset::requireUrl('assets/icons/event/' . $file);
};
$context['icons'] = [
    'calendar'      => $icon('calendar.png'),
    'clock'         => $icon('clock.png'),
    'mapPin'        => $icon('map-pin.png'),
    'ticket'        => $icon('ticket.png'),
    'money'         => $icon('money-wallet.png'),
    'audience'      => $icon('audience.png'),
    'accessibility' => $icon('accessibility.png'),
];

/**
 * Badge shown on the title card and on every teaser image — the entry's format
 * glyph, same as the map pins and the card badges.
 */
$context['badge'] = $icon(Event\getFormatIcon($post->ID));

/**
 * Termine & Zeiten. `dates` stores ISO keys, the repeater stores the label the
 * submitter saw — pair them by index (both are written in the same loop) so the
 * weekday can be formatted, with the stored label as fallback.
 */
// Weekday names are spelled out here rather than taken from wp_date('l') so the
// page stays German even on an installation running an English WP locale.
$weekdays = [
    1 => __('Montag', 'flynt'),
    2 => __('Dienstag', 'flynt'),
    3 => __('Mittwoch', 'flynt'),
    4 => __('Donnerstag', 'flynt'),
    5 => __('Freitag', 'flynt'),
    6 => __('Samstag', 'flynt'),
    7 => __('Sonntag', 'flynt'),
];

$formatSchedule = function ($postId) use ($config, $weekdays) {
    $dateKeys = (array) (get_field('dates', $postId) ?: []);
    $rows     = (array) (get_field('eventSchedule', $postId) ?: []);
    $entries  = [];

    // Without ISO keys the repeater is the only source, so walk that instead.
    $source = $dateKeys ?: array_keys($rows);

    foreach (array_values($source) as $index => $key) {
        $row       = $rows[$index] ?? [];
        $timestamp = $dateKeys ? strtotime($key) : false;
        $fallback  = $config['dates'][$key] ?? ($row['date'] ?? '');

        $start = trim((string) ($row['timeStart'] ?? ''));
        $end   = trim((string) ($row['timeEnd'] ?? ''));

        $entries[] = [
            'long'  => $timestamp
                ? $weekdays[(int) wp_date('N', $timestamp)] . ', ' . wp_date('d.m.Y', $timestamp)
                : $fallback,
            'short' => $timestamp ? wp_date('d.m.y', $timestamp) : $fallback,
            'time'  => $start . ($end ? '–' . $end : ''),
        ];
    }

    return array_values(array_filter($entries, function ($entry) {
        return $entry['long'] !== '' || $entry['time'] !== '';
    }));
};
$context['schedule'] = $formatSchedule($post->ID);

// Location. There is no venue name / venue website field yet, so the block
// shows the submitted address plus a map link.
$street     = trim((string) $post->meta('street'));
$postalCode = trim((string) $post->meta('postalCode'));
$context['address'] = trim(implode(' ', array_filter([
    $street ? $street . ',' : '',
    trim($postalCode . ' Berlin'),
])));

$location = $post->meta('location');
$context['mapsUrl'] = '';
if (!empty($location['lat']) && !empty($location['lng'])) {
    $context['mapsUrl'] = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($location['lat'] . ',' . $location['lng']);
} elseif ($street || $postalCode) {
    $context['mapsUrl'] = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode(Event\composeAddress($street, $postalCode));
}

// Image fields are stored as attachment IDs — read the raw meta so the ACF
// image formatter (which returns a Timber\Image) stays out of the way.
$logoId = get_post_meta($post->ID, 'orgLogo', true);
$context['orgLogoUrl'] = $logoId ? wp_get_attachment_image_url((int) $logoId, 'medium') : '';

$galleryIds = get_post_meta($post->ID, 'gallery', true);
$context['galleryUrls'] = array_values(array_filter(array_map(function ($id) {
    return wp_get_attachment_image_url((int) $id, 'large');
}, (array) ($galleryIds ?: []))));

// "Zurück zum Programm" / "Programm entdecken" point at the program page when
// the client has created one, otherwise at the event archive.
$programPage = get_page_by_path('programm');
$context['programLink'] = $programPage ? get_permalink($programPage) : get_post_type_archive_link(Event\POST_TYPE);

/**
 * Related program entries: same kind of program point first, topped up with the
 * most recent entries so the row is always full.
 */
$programTypes = (array) ($post->meta('programTypes') ?: []);
$related = [];

if ($programTypes) {
    $metaQuery = ['relation' => 'OR'];
    foreach ($programTypes as $type) {
        $metaQuery[] = ['key' => 'programTypes', 'value' => '"' . $type . '"', 'compare' => 'LIKE'];
    }
    $related = get_posts([
        'post_type'      => Event\POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => [$post->ID],
        'meta_query'     => $metaQuery,
    ]);
}

if (count($related) < 3) {
    $exclude = array_merge([$post->ID], wp_list_pluck($related, 'ID'));
    $related = array_merge($related, get_posts([
        'post_type'      => Event\POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => 3 - count($related),
        'post__not_in'   => $exclude,
    ]));
}

$context['relatedEvents'] = array_map(function ($entry) use ($config, $mapLabels, $formatSchedule, $icon) {
    $accessibility = (array) (get_field('accessibility', $entry->ID) ?: []);
    $audiences     = (array) (get_field('audiences', $entry->ID) ?: []);

    // Trailing icon row: audience group + accessibility, when either applies.
    $markers = [];
    if (array_intersect($audiences, ['familien', 'jugend'])) {
        $markers[] = ['src' => $icon('family.png'), 'label' => __('Für Familien & Kinder geeignet', 'flynt')];
    }
    if ($accessibility && !in_array('keine', $accessibility, true)) {
        $markers[] = ['src' => $icon('accessibility.png'), 'label' => __('Barrierefrei', 'flynt')];
    }

    return [
        'title'        => get_the_title($entry),
        'link'         => get_permalink($entry),
        'thumbnail'    => get_the_post_thumbnail_url($entry, 'large'),
        'badge'        => $icon(Event\getFormatIcon($entry->ID)),
        'schedule'     => $formatSchedule($entry->ID),
        'programTypes' => $mapLabels(get_field('programTypes', $entry->ID), $config['programTypes']),
        'sectors'      => $mapLabels(get_field('sectors', $entry->ID), $config['sectors']),
        'orgName'      => get_field('orgName', $entry->ID),
        'markers'      => $markers,
    ];
}, $related);

Timber::render('templates/single-event.twig', $context);
