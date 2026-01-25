<?php

namespace Flynt\Components\SliderBoxText;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SliderBoxText', function ($data) {
    $translatableOptions = Options::getTranslatable('SliderOptions');
    $data['jsonData'] = [
        'options' => array_merge($translatableOptions, $data['options']),
    ];
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'SliderBoxText',
        'label' => 'Carousel: Text',
        'sub_fields' => [
            [
                'label' => __('Title', 'flynt'),
                'name' => 'titleTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title Text', 'flynt'),
                'name' => 'blockTitleHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Photos', 'flynt'),
                'name' => 'photosTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Boxes', 'flynt'),
                'name' => 'boxes',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'button_label' => __('Add Item', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'required' => 0,
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text'
                    ],
                    [
                        'label' => __('Subtitle', 'flynt'),
                        'name' => 'subtitle',
                        'type' => 'text'
                    ],
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'textarea',
                    ],
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
                    FieldVariables\getComponentLabel(),
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                ]
            ]
        ]
    ];
}
