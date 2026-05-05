<?php

use ACFComposer\ACFComposer;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'categoryFields',
        'title' => __('Category Settings', 'flynt'),
        'style' => 'default',
        'fields' => [
            [
                'label' => __('Color', 'flynt'),
                'name' => 'categoryColor',
                'type' => 'color_picker',
                'instructions' => __('Pick a color for this category. Used to theme projects assigned to it.', 'flynt'),
                'return_format' => 'string',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'category',
                ],
            ],
        ],
    ]);
});
