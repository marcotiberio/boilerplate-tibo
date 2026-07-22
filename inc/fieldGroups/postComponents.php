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
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'postIntro',
                'type' => 'textarea',
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Author', 'flynt'),
                'name' => 'postAuthor',
                'type' => 'text',
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            // [
            //     'label' => __('Author', 'flynt'),
            //     'name' => 'postAuthor',
            //     'type' => 'relationship',
            //     'post_type' => ['author'],
            //     'filters' => ['search'],
            //     'return_format' => 'object',
            //     'min' => 0,
            //     'max' => 0,
            //     'wrapper' => [
            //         'width' => 50,
            //     ]
            // ],
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
    ACFComposer::registerFieldGroup([
        'name' => 'postComponents',
        'title' => __('Post Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'postComponents',
                'label' => __('Post Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockAnchor\getACFLayout(),
                    Components\BlockImagePost\getACFLayout(),
                    Components\BlockGalleryMedia\getACFLayout(),
                    Components\BlockSpacer\getACFLayout(),
                    Components\BlockWysiwyg\getACFLayout(),
                ],
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
});
