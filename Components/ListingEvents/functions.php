<?php

namespace Flynt\Components\ListingEvents;

use Flynt\FieldVariables;
use Flynt\Listings;
use Flynt\Utils\Options;

const POST_TYPE = 'tribe_events';
const FORMAT_TAXONOMY = 'tribe_events_cat';

add_filter('Flynt/addComponentData?name=ListingEvents', function ($data) {
    $mode = $data['mode'] ?? 'teaser';
    $labels = $data['labels'] ?? [];
    $data['items'] = [];
    $data['filterGroups'] = [];

    // Requires The Events Calendar.
    if (!function_exists('tribe_get_events')) {
        return $data;
    }

    $events = tribe_get_events([
        'start_date' => 'now',
        'posts_per_page' => $mode === 'teaser' ? (int) ($data['count'] ?? 3) : -1,
        'eventDisplay' => 'list',
    ]);

    $data['items'] = array_map(function ($event) use ($labels) {
        $id = $event->ID;
        $format = Listings\getPostTerms($id, FORMAT_TAXONOMY);
        $place = function_exists('tribe_get_city') ? tribe_get_city($id) : '';
        if (empty($place) && function_exists('tribe_get_venue')) {
            $place = tribe_get_venue($id);
        }
        $allDay = function_exists('tribe_event_is_all_day') && tribe_event_is_all_day($id);

        return [
            'title' => get_post_field('post_title', $id),
            'link' => get_permalink($id),
            'date' => tribe_get_start_date($id, false, 'j. F Y'),
            'dateTime' => tribe_get_start_date($id, false, 'Y-m-d'),
            'time' => $allDay ? '' : tribe_get_start_date($id, false, 'H:i') . ' ' . ($labels['timeSuffix'] ?? ''),
            'meta' => implode(' · ', array_filter(array_merge($format['names'], [wp_strip_all_tags((string) $place)]))),
            'excerpt' => Listings\getExcerpt($id, 25),
            'filterTerms' => [
                'format' => $format['slugs'],
            ],
        ];
    }, $events);

    if ($mode === 'archive') {
        $data['filterGroups'] = [
            Listings\getFilterGroup(FORMAT_TAXONOMY, 'format', $labels['filterFormat'] ?? ''),
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingEvents',
        'label' => __('Listing: Events', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Mode', 'flynt'),
                'instructions' => __('Lists upcoming events from The Events Calendar.', 'flynt'),
                'name' => 'mode',
                'type' => 'button_group',
                'choices' => [
                    'teaser' => __('Teaser (next events)', 'flynt'),
                    'archive' => __('Archive (all upcoming, with filter)', 'flynt'),
                ],
                'default_value' => 'teaser',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Number of events', 'flynt'),
                'name' => 'count',
                'type' => 'number',
                'default_value' => 3,
                'min' => 1,
                'max' => 12,
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'mode',
                            'operator' => '==',
                            'value' => 'teaser',
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Link to all events', 'flynt'),
                'name' => 'allLink',
                'type' => 'link',
                'return_format' => 'array',
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'mode',
                            'operator' => '==',
                            'value' => 'teaser',
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getSectionTheme(),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}

Options::addTranslatable('ListingEvents', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Register', 'flynt'),
                'name' => 'register',
                'type' => 'text',
                'default_value' => 'Anmelden',
                'required' => 1,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Time Suffix', 'flynt'),
                'name' => 'timeSuffix',
                'type' => 'text',
                'default_value' => 'Uhr',
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Filter: Format', 'flynt'),
                'name' => 'filterFormat',
                'type' => 'text',
                'default_value' => 'Format',
                'required' => 1,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Filter: All', 'flynt'),
                'name' => 'filterAll',
                'type' => 'text',
                'default_value' => 'Alle',
                'required' => 1,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('No Events', 'flynt'),
                'name' => 'noResults',
                'type' => 'text',
                'default_value' => 'Zurzeit sind keine Veranstaltungen geplant.',
                'required' => 1,
                'wrapper' => ['width' => 100],
            ],
        ],
    ],
]);
