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
 * Section colour theme, mapped to .section--{key} in assets/styles/_sections.scss.
 */
function getSectionTheme($default = 'mist')
{
    return [
        'label' => __('Section Theme', 'flynt'),
        'name' => 'sectionTheme',
        'type' => 'select',
        'choices' => [
            'mist' => __('Mist (page background)', 'flynt'),
            'white' => __('White', 'flynt'),
            'sage' => __('Sage', 'flynt'),
            'forest' => __('Forest', 'flynt'),
            'magenta' => __('Magenta', 'flynt'),
        ],
        'default_value' => $default,
        'return_format' => 'value',
        'wrapper' => [
            'width' => 50,
        ],
    ];
}

/**
 * Optional topo contour line art at the top edge of a section.
 */
function getDecoration($default = 'none')
{
    return [
        'label' => __('Decoration', 'flynt'),
        'name' => 'decoration',
        'type' => 'select',
        'choices' => [
            'none' => __('None', 'flynt'),
            'topo' => __('Topo lines (top)', 'flynt'),
        ],
        'default_value' => $default,
        'return_format' => 'value',
        'wrapper' => [
            'width' => 50,
        ],
    ];
}

/**
 * Small eyebrow label above a heading.
 */
function getLabel()
{
    return [
        'label' => __('Label', 'flynt'),
        'instructions' => __('Small line above the heading, e.g. "Unser Betriebssystem".', 'flynt'),
        'name' => 'label',
        'type' => 'text',
    ];
}

/**
 * Repeater of 0–$max buttons, rendered by templates/partials/_buttons.twig.
 */
function getButtons($max = 2)
{
    return [
        'label' => __('Buttons', 'flynt'),
        'name' => 'buttons',
        'type' => 'repeater',
        'layout' => 'table',
        'min' => 0,
        'max' => $max,
        'button_label' => __('Add Button', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Link', 'flynt'),
                'name' => 'link',
                'type' => 'link',
                'return_format' => 'array',
                'required' => 1,
                'wrapper' => [
                    'width' => 60,
                ],
            ],
            [
                'label' => __('Style', 'flynt'),
                'name' => 'style',
                'type' => 'select',
                'choices' => [
                    'auto' => __('Auto (forest, white on dark)', 'flynt'),
                    'forest' => __('Forest', 'flynt'),
                    'white' => __('White', 'flynt'),
                    'magenta' => __('Magenta', 'flynt'),
                    'outline' => __('Outline', 'flynt'),
                ],
                'default_value' => 'auto',
                'return_format' => 'value',
                'wrapper' => [
                    'width' => 40,
                ],
            ],
        ],
    ];
}
