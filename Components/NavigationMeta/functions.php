<?php

namespace Flynt\Components\NavigationMeta;

use Flynt\Utils\Options;

// Top "meta" bar (above the main navigation): a single highlight on the left
// and a row of quick links on the right. Editable site-wide via Flynt Options.
Options::addTranslatable('NavigationMeta', [
    [
        'label' => __('Highlight', 'flynt'),
        'name' => 'highlightTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Highlight Text', 'flynt'),
        'name' => 'highlightText',
        'type' => 'text',
        'wrapper' => ['width' => '50'],
    ],
    [
        'label' => __('Highlight Link', 'flynt'),
        'name' => 'highlightLink',
        'type' => 'link',
        'return_format' => 'array',
        'wrapper' => ['width' => '50'],
    ],
    [
        'label' => __('Quick Links', 'flynt'),
        'name' => 'linksTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Quick Links', 'flynt'),
        'name' => 'links',
        'type' => 'repeater',
        'layout' => 'row',
        'button_label' => __('Add Link', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Link', 'flynt'),
                'name' => 'link',
                'type' => 'link',
                'return_format' => 'array',
            ],
        ],
    ],
]);
