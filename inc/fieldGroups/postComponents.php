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
                'label' => __('Date Start', 'flynt'),
                'name' => 'dateStart',
                'type' => 'date_picker',
                'display_format' => 'd.m.Y',
                'return_format' => 'd.m.Y',
                'first_day' => 1,
                'required' => 0,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Date End', 'flynt'),
                'name' => 'dateEnd',
                'type' => 'date_picker',
                'display_format' => 'd.m.Y',
                'return_format' => 'd.m.Y',
                'first_day' => 1,
                'required' => 1,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Artist', 'flynt'),
                'name' => 'postArtist',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Location', 'flynt'),
                'name' => 'postLocation',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Description', 'flynt'),
                'name' => 'postDescription',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'full',
                'media_upload' => 0,
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
                    Components\BlockDivider\getACFLayout(),
                    Components\BlockImage\getACFLayout(),
                    Components\BlockImageText\getACFLayout(),
                    Components\BlockWysiwyg\getACFLayout(),
                    Components\BlockWysiwygColumns\getACFLayout(),
                    Components\ListingProjects\getACFLayout(),
                    Components\BlockSpacer\getACFLayout(),
                    Components\BlockSliderImages\getACFLayout(),
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
