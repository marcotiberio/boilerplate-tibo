<?php

/**
 * Defines field variables to be used across multiple components.
 */

namespace Flynt\FieldVariables;

function getTheme($default = '')
{
    return [
        'label' => __('Theme', 'flynt'),
        'name' => 'theme',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            '' => __('(none)', 'flynt'),
            'light' => __('Light', 'flynt'),
            'dark' => __('Dark', 'flynt'),
        ],
        'default_value' => $default,
    ];
}

function getRawSvg()
{
    return [
        'label' => __('Raw SVG', 'flynt'),
        'instructions' => sprintf(
            'Insert raw svg e. g. from <a ref="%1$s" target="_blank">%1$s</a>',
            'https://heroicons.com/'
        ),
        'name' => 'rawSvg',
        'type' => 'textarea',
        'required' => 1,
        'rows' => 1,
        'new_lines' => '',
    ];
}

function getColorBackground()
{
    return [
        'label' => __('Color Background', 'flynt'),
        'name' => 'colorBackground',
        'type' => 'color_picker',
        'wrapper' => [
            'width' => 100,
        ],
        // [
        //     'label' => __('Color Background', 'flynt'),
        //     'name' => 'colorBackground',
        //     'type' => 'select',
        //     'choices' => [
        //         'bg-transparent' => 'Transparent',
        //         'bg-orange' => 'Orange',
        //     ],
        //     'default_value' => 'transparent',
        //     'required' => 0
        // ],
    ];
}

function getColorText()
{
    return [
        'label' => __('Color Text', 'flynt'),
        'instructions' => sprintf(
            'Overrides text editor color'
        ),
        'name' => 'colorText',
        'type' => 'color_picker',
        'default_value' => '#0066FF',
        'wrapper' => [
            'width' => 100,
        ],
    ];
}

// function getBoxedTopPadding()
// {
//     return [
//         'label' => __('Custom Top Padding', 'flynt'),
//         'instructions' => sprintf(
//             'Set custom top padding for component.'
//         ),
//         'name' => 'topPadding',
//         'type' => 'select',
//         'choices' => [
//             '0' => 'None',
//             '15px' => 'Default',
//             '5vw' => 'Small', // 50px
//             '8vw' => 'Medium', // 120px
//             '160px' => 'Large',
//         ],
//         'return_format' => 'value',
//         'default_value' => '15px',
//         'wrapper' => [
//             'width' => 50,
//         ],
//     ];
// }

// function getBoxedBottomPadding()
// {
//     return [
//         'label' => __('Custom Bottom Padding', 'flynt'),
//         'instructions' => sprintf(  
//             'Set custom bottom padding for component.'
//         ),
//         'name' => 'bottomPadding',
//         'type' => 'select',
//         'choices' => [
//             '0' => 'None',
//             '15px' => 'Default',
//             '5vw' => 'Small',
//             '8vw' => 'Medium',
//             '160px' => 'Large',
//         ],
//         'return_format' => 'value',
//         'default_value' => '15px',
//         'wrapper' => [
//             'width' => 50,
//         ],
//     ];
// }

function getFirstComponent()
{
    return [
        'label' => __('First Component', 'flynt'),
        'instructions' => sprintf(  
            'Set to "Yes" if this is the first component on the page.'
        ),
        'name' => 'firstComponent',
        'type' => 'true_false',
        'ui' => 1,
        'choices' => [
        'default_value' => '',
            '1' => 'True',
            '0' => 'No',
        ],
        'return_format' => 'value',
        'default_value' => '0',
        'wrapper' => [
            'width' => 100,
        ],
    ];
}

/**
 * Text size select for component options.
 *
 * Choices are populated at runtime from the Custom Font Styles defined in
 * Global Options -> Typography, so blocks never hardcode a type scale.
 *
 * A component can use several of these by passing its own name and label.
 * Any new name must also be listed in TEXT_SIZE_FIELDS in inc/typography.php,
 * otherwise the select renders with no choices.
 *
 * @param string $default Default font-* class.
 * @param string $name Field name.
 * @param string $label Field label.
 * @return array
 */
function getTextSize($default = '', $name = 'textSize', $label = '')
{
    return [
        'label' => $label ?: __('Text Size', 'flynt'),
        'instructions' => __('Uses a style from Global Options → Typography.', 'flynt'),
        'name' => $name,
        'type' => 'select',
        'choices' => [],
        'allow_null' => 1,
        'multiple' => 0,
        'ui' => 0,
        'default_value' => $default,
        'wrapper' => [
            'width' => 100,
        ],
    ];
}

/**
 * Shared "Options" tab scaffold.
 *
 * Provides the tab plus the `options` group that components already forward to
 * their template via jsonData. It holds no fields of its own — each component
 * composes what it needs:
 *
 *   ...FieldVariables\getStyleOptions([
 *       FieldVariables\getTextSize(),
 *       FieldVariables\getColorBackground(),
 *   ]),
 *
 * @param array $fields Fields placed inside the options group.
 * @return array
 */
function getStyleOptions($fields = [])
{
    return [
        [
            'label' => __('Options', 'flynt'),
            'name' => 'optionsTab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ],
        [
            'label' => '',
            'name' => 'options',
            'type' => 'group',
            'layout' => 'row',
            'sub_fields' => $fields,
        ],
    ];
}
