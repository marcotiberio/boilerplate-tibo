<?php

namespace Flynt\Components\ListingPublications;

use Flynt\FieldVariables;
use Flynt\Listings;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'post';

add_filter('Flynt/addComponentData?name=ListingPublications', function ($data) {
    $mode = $data['mode'] ?? 'teaser';
    $ids = Listings\getPostIds(POST_TYPE, $mode, $data['source'] ?? 'latest', $data['publications'] ?? []);
    $labels = $data['labels'] ?? [];

    $data['items'] = array_map(function ($id) use ($labels) {
        $type = Listings\getPostTerms($id, 'category');
        $audience = Listings\getPostTerms($id, 'audience');
        $year = get_field('publicationYear', $id);
        $pdf = get_field('publicationPdf', $id);
        $thumbnailId = get_post_thumbnail_id($id);

        return [
            'title' => get_post_field('post_title', $id),
            'link' => !empty($pdf['url']) ? $pdf['url'] : get_permalink($id),
            'external' => !empty($pdf['url']),
            'linkLabel' => $labels['read'] ?? '',
            'image' => $thumbnailId ? Timber::get_image($thumbnailId) : null,
            'meta' => implode(' · ', array_filter(array_merge($type['names'], [$year]))),
            'excerpt' => Listings\getExcerpt($id, 20),
            'filterTerms' => [
                'type' => $type['slugs'],
                'audience' => $audience['slugs'],
            ],
        ];
    }, $ids);

    $data['filterGroups'] = $mode === 'archive' ? [
        Listings\getFilterGroup('category', 'type', $labels['filterType'] ?? ''),
        Listings\getFilterGroup('audience', 'audience', $labels['filterAudience'] ?? ''),
    ] : [];

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ListingPublications',
        'label' => __('Listing: Publications', 'flynt'),
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
                    'teaser' => __('Teaser (3 publications)', 'flynt'),
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
                'label' => __('Publications', 'flynt'),
                'name' => 'publications',
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
                'label' => __('Link to all publications', 'flynt'),
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

Options::addTranslatable('ListingPublications', [
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
                'label' => __('Read', 'flynt'),
                'name' => 'read',
                'type' => 'text',
                'default_value' => 'Lesen',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('No Results', 'flynt'),
                'name' => 'noResults',
                'type' => 'text',
                'default_value' => 'Keine Publikationen für diese Auswahl.',
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
                'label' => __('Filter: Type', 'flynt'),
                'name' => 'filterType',
                'type' => 'text',
                'default_value' => 'Typ',
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
        ],
    ],
]);
