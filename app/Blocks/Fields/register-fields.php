<?php

namespace App\Blocks\Fields;

use App\Blocks\Fields\FieldVariables;

/**
 * Register ACF field groups for all blocks.
 * Every field and sub_field must have a unique 'key'.
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
                'key' => 'field_hero_general_tab',
                'label' => __('Image', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_hero_image',
                'label' => __('Image Desktop', 'sage'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'sage'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_hero_image_mobile',
                'label' => __('Image Mobile', 'sage'),
                'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'sage'),
                'name' => 'imageMobile',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_hero_height',
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
                'key' => 'field_hero_content_tab',
                'label' => __('Content', 'sage'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_hero_title_html',
                'label' => __('Title', 'sage'),
                'name' => 'titleHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'default',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'key' => 'field_hero_button_link',
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
                'key' => 'field_imgtext_image_tab',
                'label' => __('Image', 'sage'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_imgtext_image_position',
                'label' => __('Image Position', 'sage'),
                'name' => 'imagePosition',
                'type' => 'button_group',
                'choices' => [
                    'lg:flex-row' => '<i class="dashicons dashicons-align-left"></i>',
                    'lg:flex-row-reverse' => '<i class="dashicons dashicons-align-right"></i>',
                ],
                'default_value' => 'lg:flex-row-reverse',
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_imgtext_image',
                'label' => __('Image', 'sage'),
                'instructions' => __('Image-Format: JPG, PNG, SVG.', 'sage'),
                'name' => 'image',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            [
                'key' => 'field_imgtext_content_tab',
                'label' => __('Content', 'sage'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_imgtext_content_html',
                'label' => __('Content', 'sage'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
            ],
            [
                'key' => 'field_imgtext_buttons_tab',
                'label' => __('Regular Buttons', 'sage'),
                'name' => 'regularButtonsTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_imgtext_button_link1',
                'label' => __('Button 1', 'sage'),
                'name' => 'buttonLink1',
                'type' => 'link',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_imgtext_button_link2',
                'label' => __('Button 2', 'sage'),
                'name' => 'buttonLink2',
                'type' => 'link',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'key' => 'field_imgtext_anchor_tab',
                'label' => __('Anchor Scroll Buttons', 'sage'),
                'name' => 'anchorScrollButtonsTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_imgtext_repeater_buttons',
                'label' => __('Anchor Scroll Buttons', 'sage'),
                'name' => 'repeaterButtons',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => __('Add Button', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_imgtext_repeater_button_link',
                        'label' => __('Button', 'sage'),
                        'name' => 'buttonLink',
                        'type' => 'link',
                        'required' => 0,
                    ],
                ],
            ],
            FieldVariables::optionsTab('imgtext'),
            [
                'key' => 'field_imgtext_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables::colorBackground('imgtext'),
                    FieldVariables::colorText('imgtext'),
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
                'key' => 'field_wys_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_wys_text_position',
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
                'key' => 'field_wys_content_html',
                'label' => __('Content', 'sage'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'delay' => 1,
                'media_upload' => 1,
                'required' => 1,
            ],
            [
                'key' => 'field_wys_button_link',
                'label' => __('Button', 'sage'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
            ],
            FieldVariables::optionsTab('wys'),
            [
                'key' => 'field_wys_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables::colorBackground('wys'),
                    [
                        'key' => 'field_wys_sticky_text',
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
                'key' => 'field_bcta_content_tab',
                'label' => __('Content', 'sage'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_bcta_title',
                'label' => __('Title', 'sage'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_bcta_content_html',
                'label' => __('Content', 'sage'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'delay' => 1,
                'media_upload' => 0,
            ],
            [
                'key' => 'field_bcta_button_link',
                'label' => __('Button', 'sage'),
                'name' => 'buttonLink',
                'type' => 'link',
                'required' => 0,
            ],
            [
                'key' => 'field_bcta_image_tab',
                'label' => __('Image', 'sage'),
                'name' => 'imageTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_bcta_background_image',
                'label' => __('Background Image', 'sage'),
                'name' => 'backgroundImage',
                'type' => 'image',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg,webp',
            ],
            FieldVariables::optionsTab('bcta'),
            FieldVariables::optionsGroup('bcta'),
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

    acf_add_local_field_group([
        'key' => 'group_block_gallery_media',
        'title' => 'Block: Gallery Media',
        'fields' => [
            [
                'key' => 'field_gm_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_gm_media_items',
                'label' => __('Media Items', 'sage'),
                'name' => 'mediaItems',
                'type' => 'flexible_content',
                'button_label' => __('Add Gallery Item', 'sage'),
                'layouts' => [
                    [
                        'key' => 'field_gm_layout_image',
                        'name' => 'image',
                        'label' => __('Image', 'sage'),
                        'display' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_gm_img_col_start',
                                'label' => __('Starts in column:', 'sage'),
                                'name' => 'colStart',
                                'type' => 'button_group',
                                'choices' => $grid_col_choices,
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_img_col_end',
                                'label' => __('Ends in column:', 'sage'),
                                'name' => 'colEnd',
                                'type' => 'button_group',
                                'choices' => $grid_col_end_choices,
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_img_align_y',
                                'label' => __('Align Vertically', 'sage'),
                                'name' => 'alignY',
                                'type' => 'button_group',
                                'choices' => $align_y_choices,
                                'default_value' => 'lg:items-start',
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_img_image',
                                'label' => __('Image', 'sage'),
                                'name' => 'image',
                                'type' => 'image',
                                'preview_size' => 'medium',
                                'required' => 1,
                                'mime_types' => 'jpg,jpeg,png',
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_gm_layout_video',
                        'name' => 'video_upload',
                        'label' => __('Video Upload', 'sage'),
                        'display' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_gm_vid_col_start',
                                'label' => __('Starts in column:', 'sage'),
                                'name' => 'colStart',
                                'type' => 'button_group',
                                'choices' => $grid_col_choices,
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_vid_col_end',
                                'label' => __('Ends in column:', 'sage'),
                                'name' => 'colEnd',
                                'type' => 'button_group',
                                'choices' => $grid_col_end_choices,
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_vid_align_y',
                                'label' => __('Align Vertically', 'sage'),
                                'name' => 'alignY',
                                'type' => 'button_group',
                                'choices' => $align_y_choices,
                                'default_value' => 'lg:items-start',
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_vid_file',
                                'label' => __('Video File', 'sage'),
                                'name' => 'video',
                                'type' => 'file',
                                'required' => 1,
                                'mime_types' => 'mp4, mov',
                                'return_format' => 'array',
                            ],
                        ],
                    ],
                    [
                        'key' => 'field_gm_layout_oembed',
                        'name' => 'oembed',
                        'label' => __('Video Embed', 'sage'),
                        'display' => 'block',
                        'sub_fields' => [
                            [
                                'key' => 'field_gm_oe_col_start',
                                'label' => __('Starts in column:', 'sage'),
                                'name' => 'colStart',
                                'type' => 'button_group',
                                'choices' => $grid_col_choices,
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_oe_col_end',
                                'label' => __('Ends in column:', 'sage'),
                                'name' => 'colEnd',
                                'type' => 'button_group',
                                'choices' => $grid_col_end_choices,
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_oe_align_y',
                                'label' => __('Align Vertically', 'sage'),
                                'name' => 'alignY',
                                'type' => 'button_group',
                                'choices' => $align_y_choices,
                                'default_value' => 'lg:items-start',
                                'wrapper' => ['width' => 33],
                            ],
                            [
                                'key' => 'field_gm_oe_landscape',
                                'label' => __('Video Embed ID - Landscape', 'sage'),
                                'name' => 'videoIDLandscape',
                                'type' => 'text',
                                'wrapper' => ['width' => 50],
                            ],
                            [
                                'key' => 'field_gm_oe_portrait',
                                'label' => __('Video Embed ID - Portrait', 'sage'),
                                'name' => 'videoIDPortrait',
                                'type' => 'text',
                                'wrapper' => ['width' => 50],
                            ],
                        ],
                    ],
                ],
            ],
            FieldVariables::optionsTab('gm'),
            FieldVariables::optionsGroup('gm'),
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
                'key' => 'field_gi_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_gi_title',
                'label' => __('Title', 'sage'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'key' => 'field_gi_images_tab',
                'label' => __('Images', 'sage'),
                'name' => 'imageGalleryTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_gi_items',
                'label' => __('Images', 'sage'),
                'name' => 'items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add Item', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_gi_items_image',
                        'label' => __('Image', 'sage'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'full',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
            FieldVariables::optionsTab('gi'),
            [
                'key' => 'field_gi_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'key' => 'field_gi_grid_columns',
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
                'key' => 'field_git_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_git_headline_title',
                'label' => __('Title', 'sage'),
                'name' => 'headlineTitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_git_items_tab',
                'label' => __('Items', 'sage'),
                'name' => 'itemsTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_git_items',
                'label' => __('Items', 'sage'),
                'name' => 'items',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => __('Add Item', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_git_items_image',
                        'label' => __('Image', 'sage'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,svg,webp',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'key' => 'field_git_items_title',
                        'label' => __('Title', 'sage'),
                        'name' => 'imageBoxTitle',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'key' => 'field_git_items_link',
                        'label' => __('Link', 'sage'),
                        'name' => 'imageLink',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'key' => 'field_git_items_content',
                        'label' => __('Content', 'sage'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'media_upload' => 0,
                        'delay' => 1,
                    ],
                ],
            ],
            FieldVariables::optionsTab('git'),
            [
                'key' => 'field_git_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'key' => 'field_git_grid_columns',
                        'label' => __('Grid Columns', 'sage'),
                        'name' => 'gridColumns',
                        'type' => 'button_group',
                        'choices' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'],
                        'default_value' => '4',
                    ],
                ],
            ],
            [
                'key' => 'field_git_read_more',
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
                'key' => 'field_sl_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_sl_block_title',
                'label' => __('Title', 'sage'),
                'name' => 'blockTitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_sl_logos_tab',
                'label' => __('Logos', 'sage'),
                'name' => 'logoSelectionTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_sl_content_boxes',
                'label' => __('Logos', 'sage'),
                'name' => 'contentBoxes',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => __('Add Logo', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_sl_panel_logo',
                        'label' => __('Logo/Icon', 'sage'),
                        'name' => 'panelLogo',
                        'type' => 'image',
                        'preview_size' => 'small',
                        'mime_types' => 'png,svg,jpg,jpeg',
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'key' => 'field_sl_panel_link',
                        'label' => __('Link', 'sage'),
                        'name' => 'panelLink',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
            FieldVariables::optionsTab('sl'),
            [
                'key' => 'field_sl_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array_merge(
                    [FieldVariables::colorBackground('sl')],
                    FieldVariables::autoplayFields('sl'),
                    [
                        [
                            'key' => 'field_sl_autoplay_delay',
                            'label' => __('Autoplay Delay (ms)', 'sage'),
                            'name' => 'autoplayDelay',
                            'type' => 'number',
                            'min' => 0,
                            'default_value' => 0,
                            'conditional_logic' => [
                                [['field' => 'field_sl_autoplay', 'operator' => '==', 'value' => 1]],
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
                'key' => 'field_sb_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_sb_headline_title',
                'label' => __('Title', 'sage'),
                'name' => 'headlineTitle',
                'type' => 'text',
            ],
            [
                'key' => 'field_sb_boxes',
                'label' => __('Boxes', 'sage'),
                'name' => 'boxes',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'button_label' => __('Add Box', 'sage'),
                'sub_fields' => [
                    [
                        'key' => 'field_sb_box_content',
                        'label' => __('Content', 'sage'),
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual',
                        'media_upload' => 0,
                        'delay' => 1,
                    ],
                ],
            ],
            FieldVariables::optionsTab('sb'),
            [
                'key' => 'field_sb_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => array_merge(
                    [FieldVariables::colorBackground('sb'), FieldVariables::colorText('sb')],
                    FieldVariables::autoplayFields('sb')
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
                'key' => 'field_vo_general_tab',
                'label' => __('General', 'sage'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
            ],
            [
                'key' => 'field_vo_oembed',
                'label' => __('Video', 'sage'),
                'name' => 'oembed',
                'type' => 'oembed',
                'required' => 1,
            ],
            FieldVariables::optionsTab('vo'),
            FieldVariables::optionsGroup('vo'),
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
                'key' => 'field_sp_options',
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'key' => 'field_sp_percentage_distance',
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
    | Divider
    |--------------------------------------------------------------------------
    */
    acf_add_local_field_group([
        'key' => 'group_block_divider',
        'title' => 'Block: Divider',
        'fields' => [
            [
                'key' => 'field_div_info',
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
