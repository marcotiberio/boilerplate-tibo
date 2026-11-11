<?php

namespace Flynt\Components\ListingProjects;

use Flynt\FieldVariables;
use Flynt\Listings;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'project';

add_filter('Flynt/addComponentData?name=ListingProjects', function ($data) {
    $mode = $data['mode'] ?? 'teaser';
    $ids = Listings\getPostIds(POST_TYPE, $mode, $data['source'] ?? 'latest', $data['projects'] ?? []);
    $labels = $data['labels'] ?? [];

    $data['items'] = array_map(function ($id) use ($labels) {
        $topic = Listings\getPostTerms($id, 'project-topic');
        $audience = Listings\getPostTerms($id, 'audience');
        $status = Listings\getPostTerms($id, 'project-status');
        $thumbnailId = get_post_thumbnail_id($id);

        return [
            'title' => get_post_field('post_title', $id),
            'link' => get_permalink($id),
            'linkLabel' => $labels['readMore'] ?? '',
            'image' => $thumbnailId ? Timber::get_image($thumbnailId) : null,
            'meta' => implode(' · ', array_merge($audience['names'], $status['names'])),
            'excerpt' => Listings\getExcerpt($id),
            'filterTerms' => [
                'topic' => $topic['slugs'],
                'audience' => $audience['slugs'],
                'status' => $status['slugs'],
            ],
        ];
    }, $ids);

    $data['filterGroups'] = $mode === 'archive' ? [
        Listings\getFilterGroup('project-topic', 'topic', $labels['filterTopic'] ?? ''),
        Listings\getFilterGroup('audience', 'audience', $labels['filterAudience'] ?? ''),
        Listings\getFilterGroup('project-status', 'status', $labels['filterStatus'] ?? ''),
    ] : [];

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingProjects',
        'label' => __('Listing: Projects', 'flynt'),
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
                'name' => 'mode',
                'type' => 'button_group',
                'choices' => [
                    'teaser' => __('Teaser (3 projects)', 'flynt'),
                    'archive' => __('Archive (all, with filters)', 'flynt'),
                ],
                'default_value' => 'teaser',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Source', 'flynt'),
                'name' => 'source',
                'type' => 'button_group',
                'choices' => [
                    'latest' => __('Latest', 'flynt'),
                    'manual' => __('Hand-picked', 'flynt'),
                ],
                'default_value' => 'latest',
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
                'label' => __('Projects', 'flynt'),
                'name' => 'projects',
                'type' => 'relationship',
                'post_type' => [POST_TYPE],
                'filters' => ['search', 'taxonomy'],
                'return_format' => 'id',
                'max' => 3,
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'mode',
                            'operator' => '==',
                            'value' => 'teaser',
                        ],
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'manual',
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Link to all projects', 'flynt'),
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

Options::addTranslatable('ListingProjects', [
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
                'label' => __('Read More', 'flynt'),
                'name' => 'readMore',
                'type' => 'text',
                'default_value' => 'Mehr erfahren',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('No Results', 'flynt'),
                'name' => 'noResults',
                'type' => 'text',
                'default_value' => 'Keine Projekte für diese Auswahl.',
                'required' => 1,
                'wrapper' => ['width' => 50],
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
                'label' => __('Filter: Topic', 'flynt'),
                'name' => 'filterTopic',
                'type' => 'text',
                'default_value' => 'Thema',
                'required' => 1,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Filter: Audience', 'flynt'),
                'name' => 'filterAudience',
                'type' => 'text',
                'default_value' => 'Zielgruppe',
                'required' => 1,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Filter: Status', 'flynt'),
                'name' => 'filterStatus',
                'type' => 'text',
                'default_value' => 'Status',
                'required' => 1,
                'wrapper' => ['width' => 25],
            ],
        ],
    ],
]);
