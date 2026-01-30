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
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'headlineTitle',
                'type' => 'text',
                'instructions' => __('Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.', 'flynt'),
            ],
            [
                'label' => __('Subtitle', 'flynt'),
                'name' => 'subtitleHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Slides', 'flynt'),
                'name' => 'slidesTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Slides', 'flynt'),
                'name' => 'rows',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 0,
                'button_label' => __('Add Slide', 'flynt'),
                'sub_fields' => [
                    // FieldVariables\getColorBackground(),
                    // FieldVariables\getColorText(),
                    [
                        'label' => __('Image', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'instructions' => __('Image-Format: JPG, PNG, SVG.', 'flynt'),
                        'required' => 0,
                        'mime_types' => 'jpg,jpeg,png,svg',
                        'wrapper' => [
                            'width' => 25
                        ],
                    ],
                    [
                        'label' => __('Text', 'flynt'),
                        'name' => 'text',
                        'type' => 'textarea',
                        'wrapper' => [
                            'width' => 25
                        ],
                    ],
                    [
                        'label' => __('Author', 'flynt'),
                        'name' => 'author',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 25
                        ],
                    ],
                    [
                        'label' => __('Position', 'flynt'),
                        'name' => 'position',
                        'type' => 'text',
                        'wrapper' => [
                            'width' => 25
                        ],
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
                    FieldVariables\getColorBackground(),
                    FieldVariables\getColorText(),
                ]
            ]
        ]
    ];
}
