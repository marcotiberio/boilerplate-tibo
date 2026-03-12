<?php

use ACFComposer\ACFComposer;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'authorMeta',
        'title' => 'Author Info',
        'style' => '',
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => __('Bio', 'flynt'),
                'name' => 'authorBio',
                'type' => 'textarea',
                'rows' => 4,
                'wrapper' => [
                    'width' => 100,
                ]
            ],
            [
                'label' => __('Social Media Links', 'flynt'),
                'name' => 'authorSocials',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __('Add Link', 'flynt'),
                'min' => 0,
                'max' => 10,
                'sub_fields' => [
                    [
                        'label' => __('Platform', 'flynt'),
                        'name' => 'platform',
                        'type' => 'select',
                        'choices' => [
                            'website' => 'Website',
                            'instagram' => 'Instagram',
                            'linkedin' => 'LinkedIn',
                            'x' => 'X',
                            'youtube' => 'YouTube',
                            'email' => 'Email',
                        ],
                        'wrapper' => [
                            'width' => 30,
                        ],
                    ],
                    [
                        'label' => __('URL', 'flynt'),
                        'name' => 'url',
                        'type' => 'url',
                        'wrapper' => [
                            'width' => 70,
                        ],
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'author',
                ],
            ],
        ],
    ]);
});
