<?php

namespace App\Blocks;

/**
 * Shared ACF field definitions used across multiple blocks.
 * Mirrors the Flynt FieldVariables pattern.
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

    public static function theme(string $default = ''): array
    {
        return [
            'label' => __('Theme', 'sage'),
            'name' => 'theme',
            'type' => 'select',
            'choices' => [
                '' => __('(none)', 'sage'),
                'light' => __('Light', 'sage'),
                'dark' => __('Dark', 'sage'),
            ],
            'default_value' => $default,
        ];
    }
}
