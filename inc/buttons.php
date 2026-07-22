<?php

namespace Flynt\Typography;

use Flynt\Utils\Options;

add_action('acf/init', function () {
    // Button Styles — separate options group
    Options::addGlobal('Buttons', [
        [
            'label' => __('Button Font Style', 'flynt'),
            'instructions' => __('Configure font settings for all buttons.', 'flynt'),
            'name' => 'buttonFontStyle',
            'type' => 'group',
            'layout' => 'block',
            'sub_fields' => [
                [
                    'label' => __('Font Family', 'flynt'),
                    'instructions' => __('Leave empty to use body font.', 'flynt'),
                    'name' => 'fontFamily',
                    'type' => 'text',
                    'placeholder' => 'Leave empty to use body font',
                    'wrapper' => [
                        'width' => 20,
                    ],
                ],
                [
                    'label' => __('Font Size', 'flynt'),
                    'instructions' => __('Font size in rem for buttons.', 'flynt'),
                    'name' => 'fontSize',
                    'type' => 'number',
                    'default_value' => 1,
                    'min' => 0.5,
                    'max' => 3,
                    'step' => 0.125,
                    'wrapper' => [
                        'width' => 20,
                    ],
                ],
                [
                    'label' => __('Line Height', 'flynt'),
                    'instructions' => __('Line height (unitless value, e.g., 1.2).', 'flynt'),
                    'name' => 'lineHeight',
                    'type' => 'number',
                    'default_value' => 1.2,
                    'min' => 0.8,
                    'max' => 2,
                    'step' => 0.1,
                    'wrapper' => [
                        'width' => 20,
                    ],
                ],
                [
                    'label' => __('Font Weight', 'flynt'),
                    'instructions' => __('Font weight for buttons.', 'flynt'),
                    'name' => 'fontWeight',
                    'type' => 'select',
                    'choices' => [
                        '300' => '300 (Light)',
                        '400' => '400 (Regular)',
                        '500' => '500 (Medium)',
                        '600' => '600 (Semibold)',
                        '700' => '700 (Bold)',
                        '800' => '800 (Extrabold)',
                        '900' => '900 (Heavy)',
                    ],
                    'default_value' => '500',
                    'wrapper' => [
                        'width' => 20,
                    ],
                ],
                [
                    'label' => __('Text Transform', 'flynt'),
                    'instructions' => __('Text transformation for buttons.', 'flynt'),
                    'name' => 'textTransform',
                    'type' => 'select',
                    'choices' => [
                        'none' => 'None',
                        'capitalize' => 'Capitalize',
                        'lowercase' => 'lowercase',
                        'uppercase' => 'UPPERCASE',
                    ],
                    'default_value' => 'Capitalize',
                    'wrapper' => [
                        'width' => 20,
                    ],
                ],
            ],
        ],
        [
            'label' => __('Default Button Colors', 'flynt'),
            'instructions' => __('Configure default colors for all buttons. These apply unless overridden by custom button styles.', 'flynt'),
            'name' => 'buttonColors',
            'type' => 'group',
            'layout' => 'block',
            'sub_fields' => [
                [
                    'label' => __('Background Color', 'flynt'),
                    'instructions' => __('Default button background color', 'flynt'),
                    'name' => 'backgroundColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 25,
                    ],
                ],
                [
                    'label' => __('Text Color', 'flynt'),
                    'instructions' => __('Default button text color', 'flynt'),
                    'name' => 'textColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 25,
                    ],
                ],
                [
                    'label' => __('Hover Background Color', 'flynt'),
                    'instructions' => __('Default button background color on hover', 'flynt'),
                    'name' => 'hoverBackgroundColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 25,
                    ],
                ],
                [
                    'label' => __('Hover Text Color', 'flynt'),
                    'instructions' => __('Default button text color on hover', 'flynt'),
                    'name' => 'hoverTextColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 25,
                    ],
                ],
            ],
        ],
        [
            'label' => __('Custom Button Styles', 'flynt'),
            'instructions' => __('Define custom button styles that will be available as classes in the WYSIWYG editor.', 'flynt'),
            'name' => 'customButtonStyles',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => __('Add Button Style', 'flynt'),
            'sub_fields' => [
                [
                    'label' => __('Style Name', 'flynt'),
                    'instructions' => __('Display name for this style (shown in editor dropdown)', 'flynt'),
                    'name' => 'styleName',
                    'type' => 'text',
                    'required' => 1,
                    'wrapper' => [
                        'width' => 20,
                    ],
                ],
                [
                    'label' => __('CSS Class Name', 'flynt'),
                    'instructions' => __('Class name without "button--" prefix (e.g., "customBlue" becomes "button--customBlue").', 'flynt'),
                    'name' => 'className',
                    'type' => 'text',
                    'required' => 1,
                    'placeholder' => 'customBlue',
                    'wrapper' => [
                        'width' => 15,
                    ],
                ],
                [
                    'label' => __('Font Family', 'flynt'),
                    'name' => 'fontFamily',
                    'type' => 'select',
                    'choices' => [
                        '' => 'Default (Button Font)',
                        'heading' => 'Primary',
                        'body' => 'Secondary',
                    ],
                    'default_value' => '',
                    'wrapper' => [
                        'width' => 10,
                    ],
                ],
                [
                    'label' => __('Underline', 'flynt'),
                    'name' => 'textUnderline',
                    'type' => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Arrow →', 'flynt'),
                    'name' => 'showArrow',
                    'type' => 'true_false',
                    'default_value' => 0,
                    'ui' => 1,
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('BG Color', 'flynt'),
                    'instructions' => __('Leave empty for transparent.', 'flynt'),
                    'name' => 'backgroundColor',
                    'type' => 'color_picker',
                    'default_value' => '#3d6bff',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Text Color', 'flynt'),
                    'name' => 'textColor',
                    'type' => 'color_picker',
                    'default_value' => '#ffffff',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Border Color', 'flynt'),
                    'instructions' => __('Leave empty for no border.', 'flynt'),
                    'name' => 'borderColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Hover BG', 'flynt'),
                    'name' => 'hoverBackgroundColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Hover Text', 'flynt'),
                    'name' => 'hoverTextColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Hover Border', 'flynt'),
                    'name' => 'hoverBorderColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Category', 'flynt'),
                    'instructions' => __('Category for grouping styles in the editor dropdown.', 'flynt'),
                    'name' => 'category',
                    'type' => 'text',
                    'default_value' => 'Buttons',
                    'placeholder' => 'Buttons',
                    'wrapper' => [
                        'width' => 30,
                    ],
                ],
            ],
        ],
    ], 'Buttons');
});

// Keep the Buttons options accordion expanded by default
add_filter('acf/load_field/name=global_Buttons_', function ($field) {
    $field['open'] = 1;
    return $field;
});
