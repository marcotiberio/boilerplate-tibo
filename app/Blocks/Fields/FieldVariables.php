<?php

namespace App\Blocks\Fields;

/**
 * Shared ACF field definitions used across multiple blocks.
 * Equivalent to Flynt's FieldVariables.
 *
 * Each method accepts a $prefix to generate unique keys per block.
 */
class FieldVariables
{
    public static function colorBackground(string $prefix = ''): array
    {
        return [
            'key' => "field_{$prefix}_color_background",
            'label' => __('Color Background', 'sage'),
            'name' => 'colorBackground',
            'type' => 'color_picker',
            'wrapper' => [
                'width' => 100,
            ],
        ];
    }

    public static function colorText(string $prefix = ''): array
    {
        return [
            'key' => "field_{$prefix}_color_text",
            'label' => __('Color Text', 'sage'),
            'instructions' => 'Overrides text editor color',
            'name' => 'colorText',
            'type' => 'color_picker',
            'default_value' => '#0066FF',
            'wrapper' => [
                'width' => 100,
            ],
        ];
    }

    public static function optionsGroup(string $prefix = '', array $extra_fields = []): array
    {
        $sub_fields = array_merge([
            self::colorBackground($prefix),
            self::colorText($prefix),
        ], $extra_fields);

        return [
            'key' => "field_{$prefix}_options",
            'label' => '',
            'name' => 'options',
            'type' => 'group',
            'layout' => 'row',
            'sub_fields' => $sub_fields,
        ];
    }

    public static function optionsTab(string $prefix = ''): array
    {
        return [
            'key' => "field_{$prefix}_options_tab",
            'label' => __('Options', 'sage'),
            'name' => 'optionsTab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ];
    }

    public static function autoplayFields(string $prefix = ''): array
    {
        return [
            [
                'key' => "field_{$prefix}_autoplay",
                'label' => __('Enable Autoplay', 'sage'),
                'name' => 'autoplay',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
                'key' => "field_{$prefix}_autoplay_speed",
                'label' => __('Autoplay Speed (ms)', 'sage'),
                'name' => 'autoplaySpeed',
                'type' => 'number',
                'min' => 0,
                'step' => 1,
                'default_value' => 4000,
                'required' => 0,
                'conditional_logic' => [
                    [
                        [
                            'field' => "field_{$prefix}_autoplay",
                            'operator' => '==',
                            'value' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}
