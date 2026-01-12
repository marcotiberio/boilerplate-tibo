<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageMeta',
        'title' => 'Page Meta',
        'style' => '',
        'fields' => [
            [
                'label' => __('Page Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            // [
            //     'label' => __('Page Background', 'flynt'),
            //     'name' => 'pageBackground',
            //     'type' => 'color_picker',
            //     'default' => '#000',
            //     'required' => 0
            // ],
            [
                'label' => __('Page Background Color', 'flynt'),
                'name' => 'pageBackgroundCustom',
                'type' => 'select',
                'choices' => [
                    'bg-white' => 'White',
                    'bg-orange' => 'Orange',
                ],
                'default_value' => 'bg-white',
                'required' => 0
            ],
            [
                'label' => 'CTA Button',
                'name' => 'ctaButton',
                'type' => 'link',
                'return_format' => 'array',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page'
                ]
                ],
        ],
        'menu_order' => 0,
        'position' => 'side',
    ]);
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => __('Page Components', 'flynt'),
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => __('Page Components', 'flynt'),
                'type' => 'flexible_content',
                'button_label' => __('Add Component', 'flynt'),
                'layouts' => [
                    Components\BlockAnchor\getACFLayout(),
                    Components\BlockBannerCta\getACFLayout(),
                    Components\BlockDivider\getACFLayout(),
                    Components\BlockImageTest2\getACFLayout(),
                    Components\BlockGalleryMedia\getACFLayout(),
                    Components\BlockWysiwyg\getACFLayout(),
                    Components\GridImages\getACFLayout(),
                    Components\GridImageText\getACFLayout(),
                    Components\HeroHeaderHome\getACFLayout(),
                    // Components\ListingJournal\getACFLayout(),
                    Components\ListingVideoFeat\getACFLayout(),
                    Components\ListingVideo\getACFLayout(),
                    // Components\ListingProjects\getACFLayout(),
                    // Components\ListingProjectsFeat\getACFLayout(),
                    Components\BlockSliderLogos\getACFLayout(),
                    Components\BlockSpacer\getACFLayout(),
                    Components\SliderBox\getACFLayout(),
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'post'
                ],
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'video'
                ],
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'reusable-components'
                ],
            ],
        ],
    ]);
});
