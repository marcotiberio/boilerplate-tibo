<?php

namespace Flynt\Components\SliderImages;

add_filter('Flynt/addComponentData?name=SliderImages', function ($data) {
    $data['images'] = array_values(array_filter(array_map(function ($row) {
        return $row['image'] ?? null;
    }, $data['images'] ?? [])));

    $data['jsonData'] = [
        'options' => $data['options'] ?? [],
    ];

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'SliderImages',
        'label' => __('Carousel: Media', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
            ],
            [
                'label' => __('Images', 'flynt'),
                'instructions' => __('Each image keeps its own aspect ratio at a fixed height, so landscape images span wider slides than portrait ones.', 'flynt'),
                'name' => 'images',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => __('Add Image', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'required' => 1,
                        'mime_types' => 'jpg,jpeg,png,webp',
                    ],
                ],
            ],
            [
                'label' => __('Caption', 'flynt'),
                'instructions' => __('Optional text shown below the slider.', 'flynt'),
                'name' => 'caption',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
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
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Enable Autoplay', 'flynt'),
                        'name' => 'autoplay',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                    [
                        'label' => __('Autoplay Speed (in milliseconds)', 'flynt'),
                        'name' => 'autoplaySpeed',
                        'type' => 'number',
                        'min' => 1,
                        'step' => 1,
                        'default_value' => 5000,
                        'required' => 0,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'autoplay',
                                    'operator' => '==',
                                    'value' => 1,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];
}
