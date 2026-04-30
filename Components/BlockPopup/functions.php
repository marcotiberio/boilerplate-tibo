<?php

namespace Flynt\Components\BlockPopup;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'name' => 'BlockPopup',
        'label' => __('Popup (Modal)', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Image', 'flynt'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Image Position', 'flynt'),
                'name' => 'imagePosition',
                'type' => 'button_group',
                'choices' => [
                    'lg:flex-row' => sprintf('<i class=\'dashicons dashicons-align-left\' title=\'%1$s\'></i>', __('Image on the left', 'flynt')),
                    'lg:flex-row-reverse' => sprintf('<i class=\'dashicons dashicons-align-right\' title=\'%1$s\'></i>', __('Image on the right', 'flynt'))
                ],
                'default' => 'lg:flex-row',
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Image', 'flynt'),
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'required' => 0,
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' =>  [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'required' => 0,
                'wrapper' =>  [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Button Newsletter', 'flynt'),
                'name' => 'buttonNewsletter',
                'type' => 'link',
                'required' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                    [
                        'label' => __('Popup ID', 'flynt'),
                        'instructions' => __('Unique identifier for this popup. Change to re-show after users have dismissed it.', 'flynt'),
                        'name' => 'popupId',
                        'type' => 'text',
                        'default_value' => 'default',
                        'required' => 1,
                    ],
                    [
                        'label' => __('Show Delay (seconds)', 'flynt'),
                        'instructions' => __('Wait this many seconds after page load before showing the popup.', 'flynt'),
                        'name' => 'showDelaySeconds',
                        'type' => 'number',
                        'default_value' => 0,
                        'min' => 0,
                        'step' => 1,
                    ],
                    [
                        'label' => __('Close on Backdrop Click', 'flynt'),
                        'name' => 'closeOnBackdrop',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => __('Yes', 'flynt'),
                        'ui_off_text' => __('No', 'flynt'),
                    ],
                ]
            ]
        ]
    ];
}
