<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'postMeta',
        'title' => 'Blog Info',
        'style' => '',
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => 'Date',
                'instructions' => '',
                'required' => 0,
                'name' => 'postDate',
                'type' => 'date_picker',
                'display_format' => 'd.m.Y',
                'return_format' => 'd.m.Y',
                'first_day' => 1,
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Content', 'flynt'),
                'name' => 'postContent',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'width' => 100,
                ]
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
            ],
        ],
    ]);
    // ACFComposer::registerFieldGroup([
    //     'name' => 'postMedia',
    //     'title' => 'Featured Media',
    //     'style' => '',
    //     'menu_order' => 1,
    //     'position' => 'side',
    //     'fields' => [
            
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'post',
    //             ],
    //         ],
    //     ],
    // ]);
    // ACFComposer::registerFieldGroup([
    //     'name' => 'postComponents',
    //     'title' => __('Post Components', 'flynt'),
    //     'style' => 'seamless',
    //     'fields' => [
    //         [
    //             'name' => 'postComponents',
    //             'label' => __('Post Components', 'flynt'),
    //             'type' => 'flexible_content',
    //             'button_label' => __('Add Component', 'flynt'),
    //             'layouts' => [
    //                 Components\BlockAnchor\getACFLayout(),
    //                 Components\BlockImageTest2\getACFLayout(),
    //                 Components\BlockGalleryMedia\getACFLayout(),
    //                 Components\BlockSpacer\getACFLayout(),
    //                 Components\BlockWysiwyg\getACFLayout(),
    //             ],
    //         ],
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'post',
    //             ],
    //         ],
    //     ],
    // ]);
});
