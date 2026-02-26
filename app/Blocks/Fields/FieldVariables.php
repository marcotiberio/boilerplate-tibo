<?php

namespace App\Blocks\Fields;

/**
 * Shared ACF field definitions used across multiple blocks.
 * Equivalent to Flynt's FieldVariables.
 */
class FieldVariables
{
    public static function colorBackground(): array
    {
        return [
            'label' => __('Color Background', 'sage'),
            'name' => 'colorBackground',
            'type' => 'color_picker',
            'wrapper' => [
                'width' => 100,
            ],
        ];
    }

    public static function colorText(): array
    {
        return [
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

    public static function optionsGroup(array $extra_fields = []): array
    {
        $sub_fields = array_merge([
            self::colorBackground(),
            self::colorText(),
        ], $extra_fields);

        return [
            'label' => '',
            'name' => 'options',
            'type' => 'group',
            'layout' => 'row',
            'sub_fields' => $sub_fields,
        ];
    }

    public static function optionsTab(): array
    {
        return [
            'label' => __('Options', 'sage'),
            'name' => 'optionsTab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ];
    }

    public static function autoplayFields(): array
    {
        return [
            [
                'label' => __('Enable Autoplay', 'sage'),
                'name' => 'autoplay',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ],
            [
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
                            'fieldPath' => 'autoplay',
                            'operator' => '==',
                            'value' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}
