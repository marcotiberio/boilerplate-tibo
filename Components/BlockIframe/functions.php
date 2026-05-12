<?php

namespace Flynt\Components\BlockIframe;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'blockIframe',
        'label' => __('Block: Iframe Embed', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Iframe URL', 'flynt'),
                'instructions' => __('Full URL of the iframe `src` (e.g. https://datawrapper.dwcdn.net/3bOo9/2/).', 'flynt'),
                'name' => 'iframeUrl',
                'type' => 'url',
                'required' => 1,
            ],
            [
                'label' => __('Iframe Title', 'flynt'),
                'instructions' => __('Accessible title describing the embedded content. Required for screen readers.', 'flynt'),
                'name' => 'iframeTitle',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'label' => __('Initial Height (px)', 'flynt'),
                'instructions' => __('Starting height in pixels. If auto-resize is enabled and the source sends height messages, this will be adjusted on the fly.', 'flynt'),
                'name' => 'iframeHeight',
                'type' => 'number',
                'default_value' => 600,
                'min' => 100,
                'step' => 10,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Iframe ID', 'flynt'),
                'instructions' => __('Optional. Some services (e.g. Datawrapper) include a unique ID like `datawrapper-chart-3bOo9`.', 'flynt'),
                'name' => 'iframeId',
                'type' => 'text',
                'required' => 0,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Caption', 'flynt'),
                'name' => 'caption',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Auto-resize height', 'flynt'),
                'instructions' => __('Listen for Datawrapper-style postMessage height events and resize the iframe automatically.', 'flynt'),
                'name' => 'autoResize',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => __('Yes', 'flynt'),
                'ui_off_text' => __('No', 'flynt'),
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Allow scrolling', 'flynt'),
                'name' => 'scrolling',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => __('Yes', 'flynt'),
                'ui_off_text' => __('No', 'flynt'),
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Auto-resize height', 'flynt'),
                        'instructions' => __('Listen for Datawrapper-style postMessage height events and resize the iframe automatically.', 'flynt'),
                        'name' => 'autoResize',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => __('Allow scrolling', 'flynt'),
                        'name' => 'scrolling',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                    [
                        'label' => __('Top Border', 'flynt'),
                        'name' => 'topBorder',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                    ],
                ],
            ],
        ],
    ];
}
