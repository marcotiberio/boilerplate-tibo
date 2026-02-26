<?php

namespace App\Blocks\Fields;

use App\Blocks\Fields\FieldVariables;

/**
 * Register ACF field groups for all blocks.
 * Each field group targets its corresponding ACF block.
 */
add_action('acf/init', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Hero Image
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_hero_image',
        'title' => 'Block: Hero Image',
        'fields' => [
            [
                'label' => __('Image', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Image Desktop', 'sage'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'sage'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Image Mobile', 'sage'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'sage'),
                'name' => 'imageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Height', 'sage'),
                'name' => 'height',
                'type' => 'select',
                'default_value' => 'h-screen',
                'choices' => [
                    'h-screen' => __('Full Screen', 'sage'),
                    'h-[75vh]' => __('2/3 Screen', 'sage'),
                ],
            ],
            [
                'label' => __('Content', 'sage'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Title', 'sage'),
                'name' => 'titleHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'default',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Button', 'sage'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/hero-image']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Image + Text
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_image_text',
        'title' => 'Block: Image + Text',
        'fields' => [
            [
                'label' => __('Image', 'sage'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Image Position', 'sage'),
                'name' => 'imagePosition',
                'type' => 'button_group',
                'choices' => [
                    'lg:flex-row' => '<i class="dashicons dashicons-align-left"></i>',
                    'lg:flex-row-reverse' => '<i class="dashicons dashicons-align-right"></i>',
                ],
                'default' => 'lg:flex-row-reverse',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Image', 'sage'),
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'sage'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            [
                'label' => __('Content', 'sage'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Content', 'sage'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
            ],
            [
                'label' => __('Regular Buttons', 'sage'),
                'name' => 'regularButtonsTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Button 1', 'sage'),
                'name' => 'buttonLink1',
                'type' => 'link',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Button 2', 'sage'),
                'name' => 'buttonLink2',
                'type' => 'link',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Anchor Scroll Buttons', 'sage'),
                'name' => 'anchorScrollButtonsTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Anchor Scroll Buttons', 'sage'),
                'name' => 'repeaterButtons',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => __('Add Button', 'sage'),
                'sub_fields' => [
                    [
                        'label' => __('Button', 'sage'),
                        'name' => 'buttonLink',
                        'type' => 'link',
                        'required' => 0,
                    ],
                ],
            ],
            FieldVariables::optionsTab(),
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables::colorBackground(),
                    FieldVariables::colorText(),
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/image-text']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Text Editor (Wysiwyg)
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_wysiwyg',
        'title' => 'Block: Text Editor',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Text Position', 'sage'),
                'name' => 'textPosition',
                'type' => 'button_group',
                'choices' => [
                    'left' => '<i class="dashicons dashicons-align-left"></i>',
                    'center_narrow' => '<i class="dashicons dashicons-align-center"></i>',
                    'center_full' => '<i class="dashicons dashicons-menu-alt3"></i>',
                    'right' => '<i class="dashicons dashicons-align-right"></i>',
                ],
                'default_value' => 'center_narrow',
            ],
            [
                'label' => __('Content', 'sage'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 1,
                'required' => 1,
            ],
            [
                'label' => __('Button', 'sage'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
            ],
            FieldVariables::optionsTab(),
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables::colorBackground(),
                    [
                        'label' => __('Sticky text?', 'sage'),
                        'name' => 'stickyText',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/wysiwyg']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Banner CTA
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_banner_cta',
        'title' => 'Block: Banner CTA',
        'fields' => [
            [
                'label' => __('Content', 'sage'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Title', 'sage'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Content', 'sage'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'delay' => 1,
                'media_upload' => 0,
            ],
            [
                'label' => __('Button', 'sage'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
            ],
            [
                'label' => __('Image', 'sage'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Background Image', 'sage'),
                'name' => 'backgroundImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            FieldVariables::optionsTab(),
            FieldVariables::optionsGroup(),
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/banner-cta']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Gallery Media
    |--------------------------------------------------------------------------
    */
    $grid_col_choices = [];
    for ($i = 1; $i <= 12; $i++) {
        $grid_col_choices["col-start-1 lg:col-start-{$i}"] = (string) $i;
    }

    $grid_col_end_choices = [];
    for ($i = 1; $i <= 11; $i++) {
        $grid_col_end_choices["col-end-4 lg:col-end-{$i}"] = (string) $i;
    }
    $grid_col_end_choices['col-end-4 lg:col-end-13'] = '12';

    $align_y_choices = [
        'lg:items-start' => 'Top',
        'lg:items-center' => 'Center',
        'lg:items-end' => 'Bottom',
    ];

    $grid_position_fields = [
        [
            'label' => __('Starts in column:', 'sage'),
            'name' => 'colStart',
            'type' => 'button_group',
            'choices' => $grid_col_choices,
            'wrapper' => ['width' => 33],
        ],
        [
            'label' => __('Ends in column:', 'sage'),
            'name' => 'colEnd',
            'type' => 'button_group',
            'choices' => $grid_col_end_choices,
            'wrapper' => ['width' => 33],
        ],
        [
            'label' => __('Align Vertically', 'sage'),
            'name' => 'alignY',
            'type' => 'button_group',
            'choices' => $align_y_choices,
            'default_value' => 'lg:items-start',
            'wrapper' => ['width' => 33],
        ],
    ];

    acf_add_local_field_group([
        'key' => 'group_block_gallery_media',
        'title' => 'Block: Gallery Media',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Media Items', 'sage'),
                'name' => 'mediaItems',
                'type' => 'flexible_content',
                'button_label' => __('Add Gallery Item', 'sage'),
                'layouts' => [
                    [
                        'name' => 'image',
                        'label' => __('Image', 'sage'),
                        'display' => 'block',
                        'sub_fields' => array_merge($grid_position_fields, [
                            [
                                'label' => __('Image', 'sage'),
                                'name' => 'image',
                                'type' => 'image',
                                'preview_size' => 'medium',
                                'required' => 1,
                                'mime_types' => 'jpg,jpeg,png',
                            ],
                        ]),
                    ],
                    [
                        'name' => 'video_upload',
                        'label' => __('Video Upload', 'sage'),
                        'display' => 'block',
                        'sub_fields' => array_merge($grid_position_fields, [
                            [
                                'label' => __('Video File', 'sage'),
                                'name' => 'video',
                                'type' => 'file',
                                'required' => 1,
                                'mime_types' => 'mp4, mov',
                                'return_format' => 'array',
                            ],
                        ]),
                    ],
                    [
                        'name' => 'oembed',
                        'label' => __('Video Embed', 'sage'),
                        'display' => 'block',
                        'sub_fields' => array_merge($grid_position_fields, [
                            [
                                'label' => __('Video Embed ID - Landscape', 'sage'),
                                'name' => 'videoIDLandscape',
                                'type' => 'text',
                                'wrapper' => ['width' => 50],
                            ],
                            [
                                'label' => __('Video Embed ID - Portrait', 'sage'),
                                'name' => 'videoIDPortrait',
                                'type' => 'text',
                                'wrapper' => ['width' => 50],
                            ],
                        ]),
                    ],
                ],
            ],
            FieldVariables::optionsTab(),
            FieldVariables::optionsGroup(),
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/gallery-media']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Grid Images
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_grid_images',
        'title' => 'Block: Grid Images',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Title', 'sage'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Images', 'sage'),
                'name' => 'imageGalleryTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Images', 'sage'),
                'name' => 'items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add Item', 'sage'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'sage'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'full',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
            FieldVariables::optionsTab(),
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Grid Columns', 'sage'),
                        'name' => 'gridColumns',
                        'type' => 'button_group',
                        'choices' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'],
                        'default_value' => '4',
                    ],
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/grid-images']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Grid Image Text
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_grid_image_text',
        'title' => 'Block: Grid Image Text',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Title', 'sage'),
                'name' => 'headlineTitle',
                'type' => 'text',
            ],
            [
                'label' => __('Items', 'sage'),
                'name' => 'itemsTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Items', 'sage'),
                'name' => 'items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add Item', 'sage'),
                'sub_fields' => [
                    [
                        'label' => __('Image', 'sage'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Title', 'sage'),
                        'name' => 'imageBoxTitle',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Link', 'sage'),
                        'name' => 'imageLink',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Content', 'sage'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'media_upload' => 0,
                        'delay' => 1,
                    ],
                ],
            ],
            FieldVariables::optionsTab(),
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Grid Columns', 'sage'),
                        'name' => 'gridColumns',
                        'type' => 'button_group',
                        'choices' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'],
                        'default_value' => '4',
                    ],
                ],
            ],
            [
                'label' => __('Read More Label', 'sage'),
                'name' => 'readMoreLabel',
                'type' => 'text',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/grid-image-text']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Carousel Logos
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_slider_logos',
        'title' => 'Block: Carousel Logos',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Title', 'sage'),
                'name' => 'blockTitle',
                'type' => 'text',
            ],
            [
                'label' => __('Logos', 'sage'),
                'name' => 'logoSelectionTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Logos', 'sage'),
                'name' => 'contentBoxes',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Logo', 'sage'),
                'sub_fields' => [
                    [
                        'label' => __('Logo/Icon', 'sage'),
                        'name' => 'panelLogo',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'mime_types' => 'png,svg,jpg,jpeg',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Link', 'sage'),
                        'name' => 'panelLink',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
            FieldVariables::optionsTab(),
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array_merge(
                    [FieldVariables::colorBackground()],
                    FieldVariables::autoplayFields(),
                    [
                        [
                            'label' => __('Autoplay Delay (ms)', 'sage'),
                            'name' => 'autoplayDelay',
                            'type' => 'number',
                            'min' => 0,
                            'default_value' => 0,
                            'conditional_logic' => [
                                [['fieldPath' => 'autoplay', 'operator' => '==', 'value' => 1]],
                            ],
                        ],
                    ]
                ),
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/slider-logos']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Carousel Boxes
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_slider_box',
        'title' => 'Block: Carousel Boxes',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Title', 'sage'),
                'name' => 'headlineTitle',
                'type' => 'text',
            ],
            [
                'label' => __('Boxes', 'sage'),
                'name' => 'boxes',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'button_label' => __('Add Box', 'sage'),
                'sub_fields' => [
                    [
                        'label' => __('Content', 'sage'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'media_upload' => 0,
                        'delay' => 1,
                    ],
                ],
            ],
            FieldVariables::optionsTab(),
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array_merge(
                    [FieldVariables::colorBackground(), FieldVariables::colorText()],
                    FieldVariables::autoplayFields()
                ),
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/slider-box']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Video Embed
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_video_oembed',
        'title' => 'Block: Video Embed',
        'fields' => [
            [
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'label' => __('Video', 'sage'),
                'name' => 'oembed',
                'type' => 'oembed',
                'required' => 1,
            ],
            FieldVariables::optionsTab(),
            FieldVariables::optionsGroup(),
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/video-oembed']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Spacer
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_spacer',
        'title' => 'Block: Spacer',
        'fields' => [
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => __('Vertical Space', 'sage'),
                        'instructions' => __('Distance between sections.', 'sage'),
                        'name' => 'percentageDistance',
                        'type' => 'select',
                        'choices' => [
                            '0' => 'None',
                            '30px' => 'X-Small',
                            '5vw' => 'Small',
                            '8vw' => 'Medium',
                            '10vw' => 'Large',
                        ],
                        'default_value' => 0,
                        'return_format' => 'value',
                    ],
                ],
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/spacer']],
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Divider (no fields needed, just a visual block)
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_divider',
        'title' => 'Block: Divider',
        'fields' => [
            [
                'label' => __('Divider', 'sage'),
                'name' => 'info',
                'type' => 'message',
                'message' => 'This block displays a horizontal divider line.',
            ],
        ],
        'location' => [
            [['param' => 'block', 'operator' => '==', 'value' => 'acf/divider']],
        ],
    ]);
});
