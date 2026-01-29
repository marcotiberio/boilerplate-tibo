<?php

namespace Flynt\Typography;

use Flynt\Utils\Options;

add_action('acf/init', function () {
    // Add Typography fields to Global Options
    Options::addGlobal('Typography', [
        // Tab: Font Setup
        [
            'label' => __('Font Loading', 'flynt'),
            'name' => 'fontLoadingAccordion',
            'type' => 'accordion',
            'open' => 1,
            'multi_expand' => 1,
        ],
        [
            'label' => __('Primary Font Source', 'flynt'),
            'instructions' => __('Choose how to load the primary font: Google Fonts or upload custom font files.', 'flynt'),
            'name' => 'headingFontSource',
            'type' => 'select',
            'choices' => [
                'google' => 'Google Fonts',
                'custom' => 'Custom Upload',
            ],
            'default_value' => 'google',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Secondary Font Source', 'flynt'),
            'instructions' => __('Choose how to load the secondary font: Google Fonts or upload custom font files.', 'flynt'),
            'name' => 'bodyFontSource',
            'type' => 'select',
            'choices' => [
                'google' => 'Google Fonts',
                'custom' => 'Custom Upload',
            ],
            'default_value' => 'google',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Primary Google Fonts URL', 'flynt'),
            'instructions' => __('Paste the Google Fonts link URL for primary font. Example: https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap', 'flynt'),
            'name' => 'headingGoogleFontsUrl',
            'type' => 'url',
            'placeholder' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'headingFontSource',
                        'operator' => '==',
                        'value' => 'google',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Secondary Google Fonts URL', 'flynt'),
            'instructions' => __('Paste the Google Fonts link URL for secondary font. Example: https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap', 'flynt'),
            'name' => 'bodyGoogleFontsUrl',
            'type' => 'url',
            'placeholder' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'bodyFontSource',
                        'operator' => '==',
                        'value' => 'google',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Primary Font Uploads', 'flynt'),
            'name' => 'headingFontUploadsAccordion',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 1,
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'headingFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
        ],
        [
            'label' => __('Primary Font - Medium (500)', 'flynt'),
            'instructions' => __('Upload the medium weight font file for primary font (woff2 format recommended).', 'flynt'),
            'name' => 'headingFontMedium',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'headingFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Primary Font - Bold (700)', 'flynt'),
            'instructions' => __('Upload the bold weight font file for primary font (woff2 format recommended).', 'flynt'),
            'name' => 'headingFontBold',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'headingFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Primary Font - Heavy (900)', 'flynt'),
            'instructions' => __('Upload the heavy weight font file for primary font (woff2 format recommended).', 'flynt'),
            'name' => 'headingFontHeavy',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'headingFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Secondary Font Uploads', 'flynt'),
            'name' => 'bodyFontUploadsAccordion',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 1,
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'bodyFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
        ],
        [
            'label' => __('Secondary Font - Medium (500)', 'flynt'),
            'instructions' => __('Upload the medium weight font file for secondary font (woff2 format recommended).', 'flynt'),
            'name' => 'bodyFontMedium',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'bodyFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Secondary Font - Bold (700)', 'flynt'),
            'instructions' => __('Upload the bold weight font file for secondary font (woff2 format recommended).', 'flynt'),
            'name' => 'bodyFontBold',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'bodyFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Secondary Font - Heavy (900)', 'flynt'),
            'instructions' => __('Upload the heavy weight font file for secondary font (woff2 format recommended).', 'flynt'),
            'name' => 'bodyFontHeavy',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'bodyFontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Font Configuration', 'flynt'),
            'name' => 'fontConfigAccordion',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 1,
        ],
        [
            'label' => __('Primary Font Family', 'flynt'),
            'instructions' => __('Primary font family for headings and primary text elements.', 'flynt'),
            'name' => 'headingFontFamily',
            'type' => 'text',
            'default_value' => 'Inter',
            'placeholder' => 'Inter',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Primary Font Fallback', 'flynt'),
            'instructions' => __('Fallback fonts for primary font (e.g., Arial, sans-serif)', 'flynt'),
            'name' => 'headingFontFallback',
            'type' => 'text',
            'default_value' => 'Arial, sans-serif',
            'placeholder' => 'Arial, sans-serif',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Secondary Font Family', 'flynt'),
            'instructions' => __('Secondary font family for body text and paragraphs.', 'flynt'),
            'name' => 'bodyFontFamily',
            'type' => 'text',
            'default_value' => 'Inter',
            'placeholder' => 'Inter',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Secondary Font Fallback', 'flynt'),
            'instructions' => __('Fallback fonts for secondary font (e.g., Arial, sans-serif)', 'flynt'),
            'name' => 'bodyFontFallback',
            'type' => 'text',
            'default_value' => 'Arial, sans-serif',
            'placeholder' => 'Arial, sans-serif',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Base Font Size (Mobile)', 'flynt'),
            'instructions' => __('Base font size in pixels for mobile devices.', 'flynt'),
            'name' => 'baseFontSizeMobile',
            'type' => 'number',
            'default_value' => 14,
            'min' => 10,
            'max' => 24,
            'step' => 1,
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Base Font Size (Desktop)', 'flynt'),
            'instructions' => __('Base font size in pixels for desktop devices.', 'flynt'),
            'name' => 'baseFontSizeDesktop',
            'type' => 'number',
            'default_value' => 16,
            'min' => 12,
            'max' => 24,
            'step' => 1,
            'wrapper' => [
                'width' => 50,
            ],
        ],
        // Tab: Base Settings
        [
            'label' => __('Base Settings', 'flynt'),
            'name' => 'baseSettingsTab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ],
        [
            'label' => __('Custom Typography', 'flynt'),
            'name' => 'customTypographyAccordion',
            'type' => 'accordion',
            'open' => 1,
            'multi_expand' => 1,
        ],
        [
            'label' => __('Custom Font Styles', 'flynt'),
            'instructions' => __('Define custom font styles that will be available as classes in the WYSIWYG editor.', 'flynt'),
            'name' => 'customFontStyles',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => __('Add Font Style', 'flynt'),
            'sub_fields' => [
                [
                    'label' => __('Style Name', 'flynt'),
                    'instructions' => __('Display name for this style (shown in editor dropdown)', 'flynt'),
                    'name' => 'styleName',
                    'type' => 'text',
                    'required' => 1,
                    'wrapper' => [
                        'width' => 15,
                    ],
                ],
                [
                    'label' => __('CSS Class Name', 'flynt'),
                    'instructions' => __('Class name without "font-" prefix (e.g., "customTitle" becomes "font-customTitle")', 'flynt'),
                    'name' => 'className',
                    'type' => 'text',
                    'required' => 1,
                    'placeholder' => 'customTitle',
                    'wrapper' => [
                        'width' => 15,
                    ],
                ],
                [
                    'label' => __('HTML Heading Level', 'flynt'),
                    'instructions' => __('Select the HTML heading tag (h1-h6) for accessibility and SEO. Leave as "None" for paragraph/span elements.', 'flynt'),
                    'name' => 'headingLevel',
                    'type' => 'select',
                    'choices' => [
                        '' => 'None (Paragraph/Span)',
                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',
                    ],
                    'default_value' => '',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Font Family', 'flynt'),
                    'instructions' => __('Select which font family to use for this style.', 'flynt'),
                    'name' => 'fontFamily',
                    'type' => 'select',
                    'choices' => [
                        'heading' => 'Primary',
                        'body' => 'Secondary',
                    ],
                    'default_value' => 'heading',
                    'wrapper' => [
                        'width' => 10,
                    ],
                ],
                [
                    'label' => __('Font Size (Mobile)', 'flynt'),
                    'instructions' => __('Font size in rem for mobile devices.', 'flynt'),
                    'name' => 'sizeMobile',
                    'type' => 'number',
                    'default_value' => 1,
                    'min' => 0.5,
                    'max' => 8,
                    'step' => 0.125,
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Font Size (Desktop)', 'flynt'),
                    'instructions' => __('Font size in rem for desktop devices.', 'flynt'),
                    'name' => 'sizeDesktop',
                    'type' => 'number',
                    'default_value' => 1.25,
                    'min' => 0.5,
                    'max' => 12,
                    'step' => 0.125,
                    'wrapper' => [
                        'width' => 5,
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
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Font Weight', 'flynt'),
                    'instructions' => __('Font weight (e.g., 400, 500, 700).', 'flynt'),
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
                    'default_value' => '400',
                    'wrapper' => [
                        'width' => 15,
                    ],
                ],
                [
                    'label' => __('Text Transform', 'flynt'),
                    'instructions' => __('Text transformation for custom fonts.', 'flynt'),
                    'name' => 'textTransform',
                    'type' => 'select',
                    'choices' => [
                        'none' => 'None',
                        'capitalize' => 'Capitalize',
                        'lowercase' => 'lowercase',
                        'uppercase' => 'UPPERCASE',
                    ],
                    'default_value' => 'none',
                    'wrapper' => [
                        'width' => 15,
                    ],
                ],
                [
                    'label' => __('Category', 'flynt'),
                    'instructions' => __('Category for grouping styles in the editor dropdown.', 'flynt'),
                    'name' => 'category',
                    'type' => 'text',
                    'default_value' => 'Custom',
                    'placeholder' => 'Custom',
                    'wrapper' => [
                        'width' => 15,
                    ],
                ],
            ],
        ],
        // Tab: Button Styles
        [
            'label' => __('Button Styles', 'flynt'),
            'name' => 'buttonStylesTab',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ],
        [
            'label' => __('Default Button Typography', 'flynt'),
            'instructions' => __('Configure the default font settings for all buttons. These settings apply to all buttons unless overridden by custom button styles.', 'flynt'),
            'name' => 'buttonTypographyAccordion',
            'type' => 'accordion',
            'open' => 1,
            'multi_expand' => 1,
        ],
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
            'label' => __('Custom Button Style Variations', 'flynt'),
            'instructions' => __('Create custom button style variations with different colors. These styles will be available in the WYSIWYG editor dropdown.', 'flynt'),
            'name' => 'customButtonStylesAccordion',
            'type' => 'accordion',
            'open' => 0,
            'multi_expand' => 1,
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
                        'width' => 20,
                    ],
                ],
                [
                    'label' => __('Background Color', 'flynt'),
                    'instructions' => __('Button background color', 'flynt'),
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
                    'instructions' => __('Button text color', 'flynt'),
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
                    'instructions' => __('Button border color. Leave empty for no border.', 'flynt'),
                    'name' => 'borderColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Hover Background Color', 'flynt'),
                    'instructions' => __('Button background color on hover', 'flynt'),
                    'name' => 'hoverBackgroundColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Hover Text Color', 'flynt'),
                    'instructions' => __('Button text color on hover', 'flynt'),
                    'name' => 'hoverTextColor',
                    'type' => 'color_picker',
                    'enable_opacity' => 0,
                    'return_format' => 'string',
                    'wrapper' => [
                        'width' => 5,
                    ],
                ],
                [
                    'label' => __('Hover Border Color', 'flynt'),
                    'instructions' => __('Button border color on hover. Leave empty to use hover background color.', 'flynt'),
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
    ], 'Typography');
});

// Output dynamic CSS variables based on ACF options
add_action('wp_head', function () {
    $typographyOptions = Options::getGlobal('Typography');
    
    // Handle font loading - independent sources for heading and body fonts
    // Get font sources (with backward compatibility to old global fontSource)
    $headingFontSource = !empty($typographyOptions['headingFontSource']) 
        ? esc_attr($typographyOptions['headingFontSource']) 
        : (!empty($typographyOptions['fontSource']) 
            ? esc_attr($typographyOptions['fontSource']) 
            : 'google');
    $bodyFontSource = !empty($typographyOptions['bodyFontSource']) 
        ? esc_attr($typographyOptions['bodyFontSource']) 
        : (!empty($typographyOptions['fontSource']) 
            ? esc_attr($typographyOptions['fontSource']) 
            : 'google');
    
    // Helper function to get font URL from ACF field (handles different return formats)
    $getFontUrl = function($fieldValue) {
        if (empty($fieldValue)) {
            return '';
        }
        if (is_array($fieldValue)) {
            return !empty($fieldValue['url']) ? esc_url($fieldValue['url']) : '';
        } elseif (is_numeric($fieldValue)) {
            return esc_url(wp_get_attachment_url($fieldValue));
        } else {
            return esc_url($fieldValue);
        }
    };
    
    // Helper function to detect font format from URL
    $getFontFormat = function($url) {
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        $formatMap = [
            'woff2' => 'woff2',
            'woff' => 'woff',
            'ttf' => 'truetype',
            'otf' => 'opentype',
        ];
        return isset($formatMap[$extension]) ? $formatMap[$extension] : 'woff2';
    };
    
    // Load heading fonts based on source
    if ($headingFontSource === 'google') {
        // Load heading Google Fonts
        $headingGoogleFontsUrl = !empty($typographyOptions['headingGoogleFontsUrl']) 
            ? esc_url($typographyOptions['headingGoogleFontsUrl']) 
            : '';
        
        // Backward compatibility: if new field is empty, check old field
        if (empty($headingGoogleFontsUrl)) {
            $legacyGoogleFontsUrl = !empty($typographyOptions['googleFontsUrl']) 
                ? esc_url($typographyOptions['googleFontsUrl']) 
                : '';
            if (!empty($legacyGoogleFontsUrl)) {
                $headingGoogleFontsUrl = $legacyGoogleFontsUrl;
            }
        }
        
        if (!empty($headingGoogleFontsUrl)) {
            echo "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
            echo "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
            echo "<link id='flynt-heading-google-fonts' href='" . esc_url($headingGoogleFontsUrl) . "' rel='stylesheet'>\n";
        }
    } elseif ($headingFontSource === 'custom') {
        // Load heading custom fonts via @font-face
        $headingFont = !empty($typographyOptions['headingFontFamily']) 
            ? esc_attr($typographyOptions['headingFontFamily']) 
            : (!empty($typographyOptions['primaryFontFamily']) 
                ? esc_attr($typographyOptions['primaryFontFamily']) 
                : 'Retail');
        
        // Get heading font URLs
        $headingFontMedium = $getFontUrl($typographyOptions['headingFontMedium'] ?? '');
        $headingFontBold = $getFontUrl($typographyOptions['headingFontBold'] ?? '');
        $headingFontHeavy = $getFontUrl($typographyOptions['headingFontHeavy'] ?? '');
        
        // Generate @font-face declarations for heading fonts
        if (!empty($headingFontMedium) || !empty($headingFontBold) || !empty($headingFontHeavy)) {
            $headingFontFaceCss = "<style id='flynt-heading-custom-fonts'>\n";
            
            if (!empty($headingFontMedium)) {
                $format = $getFontFormat($headingFontMedium);
                $headingFontFaceCss .= "@font-face {\n";
                $headingFontFaceCss .= "  font-display: swap;\n";
                $headingFontFaceCss .= "  font-family: '{$headingFont}';\n";
                $headingFontFaceCss .= "  font-style: normal;\n";
                $headingFontFaceCss .= "  font-weight: 500;\n";
                $headingFontFaceCss .= "  src: url('{$headingFontMedium}') format('{$format}');\n";
                $headingFontFaceCss .= "}\n\n";
            }
            
            if (!empty($headingFontBold)) {
                $format = $getFontFormat($headingFontBold);
                $headingFontFaceCss .= "@font-face {\n";
                $headingFontFaceCss .= "  font-display: swap;\n";
                $headingFontFaceCss .= "  font-family: '{$headingFont}';\n";
                $headingFontFaceCss .= "  font-style: normal;\n";
                $headingFontFaceCss .= "  font-weight: 700;\n";
                $headingFontFaceCss .= "  src: url('{$headingFontBold}') format('{$format}');\n";
                $headingFontFaceCss .= "}\n\n";
            }
            
            if (!empty($headingFontHeavy)) {
                $format = $getFontFormat($headingFontHeavy);
                $headingFontFaceCss .= "@font-face {\n";
                $headingFontFaceCss .= "  font-display: swap;\n";
                $headingFontFaceCss .= "  font-family: '{$headingFont}';\n";
                $headingFontFaceCss .= "  font-style: normal;\n";
                $headingFontFaceCss .= "  font-weight: 900;\n";
                $headingFontFaceCss .= "  src: url('{$headingFontHeavy}') format('{$format}');\n";
                $headingFontFaceCss .= "}\n";
            }
            
            $headingFontFaceCss .= "</style>\n";
            echo $headingFontFaceCss;
        }
    }
    
    // Load body fonts based on source
    if ($bodyFontSource === 'google') {
        // Load body Google Fonts
        $bodyGoogleFontsUrl = !empty($typographyOptions['bodyGoogleFontsUrl']) 
            ? esc_url($typographyOptions['bodyGoogleFontsUrl']) 
            : '';
        
        // Backward compatibility: if new field is empty, check old field
        if (empty($bodyGoogleFontsUrl)) {
            $legacyGoogleFontsUrl = !empty($typographyOptions['googleFontsUrl']) 
                ? esc_url($typographyOptions['googleFontsUrl']) 
                : '';
            if (!empty($legacyGoogleFontsUrl)) {
                $bodyGoogleFontsUrl = $legacyGoogleFontsUrl;
            }
        }
        
        if (!empty($bodyGoogleFontsUrl)) {
            // Only output preconnect if not already output for heading fonts
            if ($headingFontSource !== 'google' || empty($typographyOptions['headingGoogleFontsUrl'])) {
                echo "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
                echo "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
            }
            // Only load if different from heading font URL
            $headingGoogleFontsUrl = !empty($typographyOptions['headingGoogleFontsUrl']) 
                ? esc_url($typographyOptions['headingGoogleFontsUrl']) 
                : '';
            if ($bodyGoogleFontsUrl !== $headingGoogleFontsUrl) {
                echo "<link id='flynt-body-google-fonts' href='" . esc_url($bodyGoogleFontsUrl) . "' rel='stylesheet'>\n";
            }
        }
    } elseif ($bodyFontSource === 'custom') {
        // Load body custom fonts via @font-face
        $bodyFont = !empty($typographyOptions['bodyFontFamily']) 
            ? esc_attr($typographyOptions['bodyFontFamily']) 
            : (!empty($typographyOptions['primaryFontFamily']) 
                ? esc_attr($typographyOptions['primaryFontFamily']) 
                : 'Retail');
        
        // Get body font URLs
        $bodyFontMedium = $getFontUrl($typographyOptions['bodyFontMedium'] ?? '');
        $bodyFontBold = $getFontUrl($typographyOptions['bodyFontBold'] ?? '');
        $bodyFontHeavy = $getFontUrl($typographyOptions['bodyFontHeavy'] ?? '');
        
        // Generate @font-face declarations for body fonts
        if (!empty($bodyFontMedium) || !empty($bodyFontBold) || !empty($bodyFontHeavy)) {
            $bodyFontFaceCss = "<style id='flynt-body-custom-fonts'>\n";
            
            if (!empty($bodyFontMedium)) {
                $format = $getFontFormat($bodyFontMedium);
                $bodyFontFaceCss .= "@font-face {\n";
                $bodyFontFaceCss .= "  font-display: swap;\n";
                $bodyFontFaceCss .= "  font-family: '{$bodyFont}';\n";
                $bodyFontFaceCss .= "  font-style: normal;\n";
                $bodyFontFaceCss .= "  font-weight: 500;\n";
                $bodyFontFaceCss .= "  src: url('{$bodyFontMedium}') format('{$format}');\n";
                $bodyFontFaceCss .= "}\n\n";
            }
            
            if (!empty($bodyFontBold)) {
                $format = $getFontFormat($bodyFontBold);
                $bodyFontFaceCss .= "@font-face {\n";
                $bodyFontFaceCss .= "  font-display: swap;\n";
                $bodyFontFaceCss .= "  font-family: '{$bodyFont}';\n";
                $bodyFontFaceCss .= "  font-style: normal;\n";
                $bodyFontFaceCss .= "  font-weight: 700;\n";
                $bodyFontFaceCss .= "  src: url('{$bodyFontBold}') format('{$format}');\n";
                $bodyFontFaceCss .= "}\n\n";
            }
            
            if (!empty($bodyFontHeavy)) {
                $format = $getFontFormat($bodyFontHeavy);
                $bodyFontFaceCss .= "@font-face {\n";
                $bodyFontFaceCss .= "  font-display: swap;\n";
                $bodyFontFaceCss .= "  font-family: '{$bodyFont}';\n";
                $bodyFontFaceCss .= "  font-style: normal;\n";
                $bodyFontFaceCss .= "  font-weight: 900;\n";
                $bodyFontFaceCss .= "  src: url('{$bodyFontHeavy}') format('{$format}');\n";
                $bodyFontFaceCss .= "}\n";
            }
            
            $bodyFontFaceCss .= "</style>\n";
            echo $bodyFontFaceCss;
        }
    }
    
    // Get values with fallbacks (backward compatibility with primaryFontFamily)
    $headingFont = !empty($typographyOptions['headingFontFamily']) 
        ? esc_attr($typographyOptions['headingFontFamily']) 
        : (!empty($typographyOptions['primaryFontFamily']) 
            ? esc_attr($typographyOptions['primaryFontFamily']) 
            : 'Inter');
    $headingFontFallback = !empty($typographyOptions['headingFontFallback']) 
        ? esc_attr($typographyOptions['headingFontFallback']) 
        : (!empty($typographyOptions['primaryFontFallback']) 
            ? esc_attr($typographyOptions['primaryFontFallback']) 
            : 'Arial, sans-serif');
    
    $bodyFont = !empty($typographyOptions['bodyFontFamily']) 
        ? esc_attr($typographyOptions['bodyFontFamily']) 
        : (!empty($typographyOptions['primaryFontFamily']) 
            ? esc_attr($typographyOptions['primaryFontFamily']) 
            : 'Inter');
    $bodyFontFallback = !empty($typographyOptions['bodyFontFallback']) 
        ? esc_attr($typographyOptions['bodyFontFallback']) 
        : (!empty($typographyOptions['primaryFontFallback']) 
            ? esc_attr($typographyOptions['primaryFontFallback']) 
            : 'Arial, sans-serif');
    // Keep primaryFont for backward compatibility
    $primaryFont = $headingFont;
    $primaryFontFallback = $headingFontFallback;
    $baseFontSizeMobile = !empty($typographyOptions['baseFontSizeMobile']) 
        ? floatval($typographyOptions['baseFontSizeMobile']) 
        : 14;
    $baseFontSizeDesktop = !empty($typographyOptions['baseFontSizeDesktop']) 
        ? floatval($typographyOptions['baseFontSizeDesktop']) 
        : 16;
    // Body font settings (used in _lists.scss)
    $bodySizeMobile = !empty($typographyOptions['bodySizeMobile']) 
        ? floatval($typographyOptions['bodySizeMobile']) 
        : 1.25;
    $bodySizeDesktop = !empty($typographyOptions['bodySizeDesktop']) 
        ? floatval($typographyOptions['bodySizeDesktop']) 
        : 1.25;
    $bodySmallSize = !empty($typographyOptions['bodySmallSize']) 
        ? floatval($typographyOptions['bodySmallSize']) 
        : 0.75;
    $bodyLineHeight = !empty($typographyOptions['bodyLineHeight']) 
        ? floatval($typographyOptions['bodyLineHeight']) 
        : 1.2;
    $bodySmallLineHeight = !empty($typographyOptions['bodySmallLineHeight']) 
        ? floatval($typographyOptions['bodySmallLineHeight']) 
        : 1.2;
    $bodyFontWeight = !empty($typographyOptions['bodyFontWeight']) 
        ? esc_attr($typographyOptions['bodyFontWeight']) 
        : '500';
    // Get button font style settings from group field
    $buttonFontStyle = !empty($typographyOptions['buttonFontStyle']) 
        ? $typographyOptions['buttonFontStyle'] 
        : [];
    $buttonFontFamily = !empty($buttonFontStyle['fontFamily']) 
        ? esc_attr($buttonFontStyle['fontFamily']) 
        : $bodyFont;
    $buttonFontSize = !empty($buttonFontStyle['fontSize']) 
        ? floatval($buttonFontStyle['fontSize']) 
        : 1;
    $buttonLineHeight = !empty($buttonFontStyle['lineHeight']) 
        ? floatval($buttonFontStyle['lineHeight']) 
        : 1.2;
    $buttonFontWeight = !empty($buttonFontStyle['fontWeight']) 
        ? esc_attr($buttonFontStyle['fontWeight']) 
        : '500';
    $buttonTextTransform = !empty($buttonFontStyle['textTransform']) 
        ? esc_attr($buttonFontStyle['textTransform']) 
        : 'none';
    
    // Get default button colors
    $buttonColors = !empty($typographyOptions['buttonColors']) 
        ? $typographyOptions['buttonColors'] 
        : [];
    $buttonBackgroundColor = !empty($buttonColors['backgroundColor']) 
        ? esc_attr($buttonColors['backgroundColor']) 
        : '';
    $buttonTextColor = !empty($buttonColors['textColor']) 
        ? esc_attr($buttonColors['textColor']) 
        : '';
    $buttonHoverBackgroundColor = !empty($buttonColors['hoverBackgroundColor']) 
        ? esc_attr($buttonColors['hoverBackgroundColor']) 
        : '';
    $buttonHoverTextColor = !empty($buttonColors['hoverTextColor']) 
        ? esc_attr($buttonColors['hoverTextColor']) 
        : '';
    
    // Build CSS variables
    $css = ":root {\n";
    $css .= "  --primary-font-family: '{$headingFont}', {$headingFontFallback};\n";
    $css .= "  --secondary-font-family: '{$bodyFont}', {$bodyFontFallback};\n";
    $css .= "  --heading-font-family: '{$headingFont}', {$headingFontFallback};\n"; // Backward compatibility
    $css .= "  --body-font-family: '{$bodyFont}', {$bodyFontFallback};\n"; // Backward compatibility
    $css .= "  --button-font-family: '{$buttonFontFamily}', {$bodyFontFallback};\n";
    $css .= "  --button-font-size: {$buttonFontSize}rem;\n";
    $css .= "  --button-line-height: {$buttonLineHeight};\n";
    $css .= "  --button-font-weight: {$buttonFontWeight};\n";
    $css .= "  --button-text-transform: {$buttonTextTransform};\n";
    if (!empty($buttonBackgroundColor)) {
        $css .= "  --button-background-color: {$buttonBackgroundColor};\n";
    }
    if (!empty($buttonTextColor)) {
        $css .= "  --button-text-color: {$buttonTextColor};\n";
    }
    if (!empty($buttonHoverBackgroundColor)) {
        $css .= "  --button-hover-background-color: {$buttonHoverBackgroundColor};\n";
    }
    if (!empty($buttonHoverTextColor)) {
        $css .= "  --button-hover-text-color: {$buttonHoverTextColor};\n";
    }
    $css .= "  --base-font-size-mobile: {$baseFontSizeMobile}px;\n";
    $css .= "  --base-font-size-desktop: {$baseFontSizeDesktop}px;\n";
    $css .= "  --body-size-mobile: {$bodySizeMobile}rem;\n";
    $css .= "  --body-size-desktop: {$bodySizeDesktop}rem;\n";
    $css .= "  --body-line-height: {$bodyLineHeight};\n";
    $css .= "  --body-font-weight: {$bodyFontWeight};\n";
    $css .= "  --body-small-size: {$bodySmallSize}rem;\n";
    $css .= "  --body-small-line-height: {$bodySmallLineHeight};\n";
    $css .= "}\n";
    
    echo "<style id='flynt-typography-css'>\n{$css}\n</style>\n";
    
    // Generate CSS for custom font styles
    $customFontStyles = !empty($typographyOptions['customFontStyles']) 
        ? $typographyOptions['customFontStyles'] 
        : [];
    
    if (!empty($customFontStyles)) {
        $customStylesCss = "<style id='flynt-custom-font-styles'>\n";
        
        foreach ($customFontStyles as $style) {
            if (empty($style['className']) || empty($style['styleName'])) {
                continue;
            }
            
            $className = esc_attr($style['className']);
            // Ensure class name starts with "font-" if it doesn't already
            if (strpos($className, 'font-') !== 0) {
                $className = 'font-' . $className;
            }
            
            $headingLevel = !empty($style['headingLevel']) 
                ? esc_attr($style['headingLevel']) 
                : '';
            
            // Get selected font family for this style
            $selectedFontFamily = !empty($style['fontFamily']) 
                ? esc_attr($style['fontFamily']) 
                : 'heading';
            
            $sizeMobile = !empty($style['sizeMobile']) 
                ? floatval($style['sizeMobile']) 
                : 1;
            $sizeDesktop = !empty($style['sizeDesktop']) 
                ? floatval($style['sizeDesktop']) 
                : $sizeMobile;
            $lineHeight = !empty($style['lineHeight']) 
                ? floatval($style['lineHeight']) 
                : 1.2;
            $fontWeight = !empty($style['fontWeight']) 
                ? esc_attr($style['fontWeight']) 
                : '400';
            $textTransform = !empty($style['textTransform']) 
                ? esc_attr($style['textTransform']) 
                : 'none';
            
            // Build selector: include HTML tag if heading level is set
            $selector = '';
            if (!empty($headingLevel)) {
                // Target both the HTML tag and the class for better compatibility
                $selector = "{$headingLevel}, .{$className}";
            } else {
                // Just target the class
                $selector = ".{$className}";
            }
            
            // Determine font family based on selection
            if ($selectedFontFamily === 'body') {
                $fontFamily = "var(--secondary-font-family, var(--body-font-family, '{$bodyFont}', {$bodyFontFallback}))";
            } else {
                // Default to primary font
                $fontFamily = "var(--primary-font-family, var(--heading-font-family, '{$headingFont}', {$headingFontFallback}))";
            }
            
            $customStylesCss .= "{$selector} {\n";
            $customStylesCss .= "  font-family: {$fontFamily};\n";
            $customStylesCss .= "  font-size: {$sizeMobile}rem;\n";
            $customStylesCss .= "  line-height: {$lineHeight};\n";
            $customStylesCss .= "  font-weight: {$fontWeight};\n";
            $customStylesCss .= "  text-transform: {$textTransform};\n";
            $customStylesCss .= "}\n\n";
            
            // Add desktop size if different
            if ($sizeDesktop != $sizeMobile) {
                $customStylesCss .= "@media (min-width: 1024px) {\n";
                // Use same selector pattern for desktop
                if (!empty($headingLevel)) {
                    $customStylesCss .= "  {$headingLevel}, .{$className} {\n";
                } else {
                    $customStylesCss .= "  .{$className} {\n";
                }
                $customStylesCss .= "    font-size: {$sizeDesktop}rem;\n";
                $customStylesCss .= "  }\n";
                $customStylesCss .= "}\n\n";
            }
        }
        
        $customStylesCss .= "</style>\n";
        echo $customStylesCss;
    }
    
    // Generate CSS for custom button styles
    $customButtonStyles = !empty($typographyOptions['customButtonStyles']) 
        ? $typographyOptions['customButtonStyles'] 
        : [];
    
    if (!empty($customButtonStyles)) {
        $customButtonCss = "<style id='flynt-custom-button-styles'>\n";
        
        foreach ($customButtonStyles as $style) {
            if (empty($style['className']) || empty($style['styleName'])) {
                continue;
            }
            
            $className = esc_attr($style['className']);
            // Ensure class name starts with "button--" if it doesn't already
            if (strpos($className, 'button--') !== 0) {
                $className = 'button--' . $className;
            }
            
            $backgroundColor = !empty($style['backgroundColor']) 
                ? esc_attr($style['backgroundColor']) 
                : 'transparent';
            $textColor = !empty($style['textColor']) 
                ? esc_attr($style['textColor']) 
                : 'inherit';
            $borderColor = !empty($style['borderColor']) 
                ? esc_attr($style['borderColor']) 
                : '';
            $hoverBackgroundColor = !empty($style['hoverBackgroundColor']) 
                ? esc_attr($style['hoverBackgroundColor']) 
                : '';
            $hoverTextColor = !empty($style['hoverTextColor']) 
                ? esc_attr($style['hoverTextColor']) 
                : '';
            $hoverBorderColor = !empty($style['hoverBorderColor']) 
                ? esc_attr($style['hoverBorderColor']) 
                : '';
            
            // Base button styles
            $customButtonCss .= ".button.{$className} {\n";
            if ($backgroundColor !== 'transparent') {
                $customButtonCss .= "  background-color: {$backgroundColor};\n";
            } else {
                $customButtonCss .= "  background-color: transparent;\n";
            }
            $customButtonCss .= "  color: {$textColor};\n";
            if (!empty($borderColor)) {
                $customButtonCss .= "  border-color: {$borderColor};\n";
            }
            $customButtonCss .= "}\n\n";
            
            // Hover styles
            if (!empty($hoverBackgroundColor) || !empty($hoverTextColor) || !empty($hoverBorderColor)) {
                $customButtonCss .= ".button.{$className}:hover,\n";
                $customButtonCss .= ".button.{$className}:focus {\n";
                if (!empty($hoverBackgroundColor)) {
                    $customButtonCss .= "  background-color: {$hoverBackgroundColor};\n";
                }
                if (!empty($hoverTextColor)) {
                    $customButtonCss .= "  color: {$hoverTextColor};\n";
                }
                if (!empty($hoverBorderColor)) {
                    $customButtonCss .= "  border-color: {$hoverBorderColor};\n";
                } elseif (!empty($hoverBackgroundColor) && empty($hoverBorderColor) && !empty($borderColor)) {
                    // Use hover background as border if border was set originally
                    $customButtonCss .= "  border-color: {$hoverBackgroundColor};\n";
                }
                $customButtonCss .= "}\n\n";
            }
        }
        
        $customButtonCss .= "</style>\n";
        echo $customButtonCss;
    }
}, 100);

// Add button font styles to TinyMCE editor
add_filter('tiny_mce_before_init', function ($init) {
    $typographyOptions = \Flynt\Utils\Options::getGlobal('Typography');
    
    // Get font sources
    $headingFontSource = !empty($typographyOptions['headingFontSource']) 
        ? esc_attr($typographyOptions['headingFontSource']) 
        : (!empty($typographyOptions['fontSource']) 
            ? esc_attr($typographyOptions['fontSource']) 
            : 'google');
    $bodyFontSource = !empty($typographyOptions['bodyFontSource']) 
        ? esc_attr($typographyOptions['bodyFontSource']) 
        : (!empty($typographyOptions['fontSource']) 
            ? esc_attr($typographyOptions['fontSource']) 
            : 'google');
    
    // Helper function to get font URL from ACF field
    $getFontUrl = function($fieldValue) {
        if (empty($fieldValue)) {
            return '';
        }
        if (is_array($fieldValue)) {
            return !empty($fieldValue['url']) ? esc_url($fieldValue['url']) : '';
        } elseif (is_numeric($fieldValue)) {
            return esc_url(wp_get_attachment_url($fieldValue));
        } else {
            return esc_url($fieldValue);
        }
    };
    
    // Helper function to detect font format from URL
    $getFontFormat = function($url) {
        $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
        $formatMap = [
            'woff2' => 'woff2',
            'woff' => 'woff',
            'ttf' => 'truetype',
            'otf' => 'opentype',
        ];
        return isset($formatMap[$extension]) ? $formatMap[$extension] : 'woff2';
    };
    
    // Get font families with backward compatibility
    $headingFont = !empty($typographyOptions['headingFontFamily']) 
        ? esc_attr($typographyOptions['headingFontFamily']) 
        : (!empty($typographyOptions['primaryFontFamily']) 
            ? esc_attr($typographyOptions['primaryFontFamily']) 
            : 'Inter');
    $headingFontFallback = !empty($typographyOptions['headingFontFallback']) 
        ? esc_attr($typographyOptions['headingFontFallback']) 
        : (!empty($typographyOptions['primaryFontFallback']) 
            ? esc_attr($typographyOptions['primaryFontFallback']) 
            : 'Arial, sans-serif');
    
    $bodyFont = !empty($typographyOptions['bodyFontFamily']) 
        ? esc_attr($typographyOptions['bodyFontFamily']) 
        : (!empty($typographyOptions['primaryFontFamily']) 
            ? esc_attr($typographyOptions['primaryFontFamily']) 
            : 'Inter');
    $bodyFontFallback = !empty($typographyOptions['bodyFontFallback']) 
        ? esc_attr($typographyOptions['bodyFontFallback']) 
        : (!empty($typographyOptions['primaryFontFallback']) 
            ? esc_attr($typographyOptions['primaryFontFallback']) 
            : 'Arial, sans-serif');
    
    // Get button font style settings
    $buttonFontStyle = !empty($typographyOptions['buttonFontStyle']) 
        ? $typographyOptions['buttonFontStyle'] 
        : [];
    $buttonFontFamily = !empty($buttonFontStyle['fontFamily']) 
        ? esc_attr($buttonFontStyle['fontFamily']) 
        : $bodyFont;
    $buttonFontSize = !empty($buttonFontStyle['fontSize']) 
        ? floatval($buttonFontStyle['fontSize']) 
        : 1;
    $buttonLineHeight = !empty($buttonFontStyle['lineHeight']) 
        ? floatval($buttonFontStyle['lineHeight']) 
        : 1.2;
    $buttonFontWeight = !empty($buttonFontStyle['fontWeight']) 
        ? esc_attr($buttonFontStyle['fontWeight']) 
        : '500';
    $buttonTextTransform = !empty($buttonFontStyle['textTransform']) 
        ? esc_attr($buttonFontStyle['textTransform']) 
        : 'none';
    
    // Add Google Fonts to TinyMCE content_css if using Google Fonts
    $contentCss = [];
    
    if ($headingFontSource === 'google') {
        $headingGoogleFontsUrl = !empty($typographyOptions['headingGoogleFontsUrl']) 
            ? esc_url($typographyOptions['headingGoogleFontsUrl']) 
            : '';
        if (empty($headingGoogleFontsUrl)) {
            $legacyGoogleFontsUrl = !empty($typographyOptions['googleFontsUrl']) 
                ? esc_url($typographyOptions['googleFontsUrl']) 
                : '';
            if (!empty($legacyGoogleFontsUrl)) {
                $headingGoogleFontsUrl = $legacyGoogleFontsUrl;
            }
        }
        if (!empty($headingGoogleFontsUrl)) {
            $contentCss[] = $headingGoogleFontsUrl;
        }
    }
    
    if ($bodyFontSource === 'google') {
        $bodyGoogleFontsUrl = !empty($typographyOptions['bodyGoogleFontsUrl']) 
            ? esc_url($typographyOptions['bodyGoogleFontsUrl']) 
            : '';
        if (empty($bodyGoogleFontsUrl)) {
            $legacyGoogleFontsUrl = !empty($typographyOptions['googleFontsUrl']) 
                ? esc_url($typographyOptions['googleFontsUrl']) 
                : '';
            if (!empty($legacyGoogleFontsUrl)) {
                $bodyGoogleFontsUrl = $legacyGoogleFontsUrl;
            }
        }
        if (!empty($bodyGoogleFontsUrl) && !in_array($bodyGoogleFontsUrl, $contentCss)) {
            $contentCss[] = $bodyGoogleFontsUrl;
        }
    }
    
    // Add Google Fonts to content_css if any
    if (!empty($contentCss)) {
        if (!empty($init['content_css'])) {
            $existingCss = is_array($init['content_css']) ? $init['content_css'] : array_filter(array_map('trim', explode(',', $init['content_css'])));
            $init['content_css'] = array_unique(array_merge($existingCss, $contentCss));
        } else {
            $init['content_css'] = $contentCss;
        }
        // Convert to comma-separated string if needed (TinyMCE accepts both)
        if (is_array($init['content_css'])) {
            $init['content_css'] = implode(',', $init['content_css']);
        }
    }
    
    // Build font loading CSS for TinyMCE editor
    $fontLoadingCss = '';
    
    // Load primary custom fonts if needed
    if ($headingFontSource === 'custom') {
        $headingFontMedium = $getFontUrl($typographyOptions['headingFontMedium'] ?? '');
        $headingFontBold = $getFontUrl($typographyOptions['headingFontBold'] ?? '');
        $headingFontHeavy = $getFontUrl($typographyOptions['headingFontHeavy'] ?? '');
        
        if (!empty($headingFontMedium)) {
            $format = $getFontFormat($headingFontMedium);
            $fontLoadingCss .= "@font-face { font-display: swap; font-family: '{$headingFont}'; font-style: normal; font-weight: 500; src: url('{$headingFontMedium}') format('{$format}'); }";
        }
        if (!empty($headingFontBold)) {
            $format = $getFontFormat($headingFontBold);
            $fontLoadingCss .= "@font-face { font-display: swap; font-family: '{$headingFont}'; font-style: normal; font-weight: 700; src: url('{$headingFontBold}') format('{$format}'); }";
        }
        if (!empty($headingFontHeavy)) {
            $format = $getFontFormat($headingFontHeavy);
            $fontLoadingCss .= "@font-face { font-display: swap; font-family: '{$headingFont}'; font-style: normal; font-weight: 900; src: url('{$headingFontHeavy}') format('{$format}'); }";
        }
    }
    
    // Load secondary custom fonts if needed
    if ($bodyFontSource === 'custom') {
        $bodyFontMedium = $getFontUrl($typographyOptions['bodyFontMedium'] ?? '');
        $bodyFontBold = $getFontUrl($typographyOptions['bodyFontBold'] ?? '');
        $bodyFontHeavy = $getFontUrl($typographyOptions['bodyFontHeavy'] ?? '');
        
        if (!empty($bodyFontMedium)) {
            $format = $getFontFormat($bodyFontMedium);
            $fontLoadingCss .= "@font-face { font-display: swap; font-family: '{$bodyFont}'; font-style: normal; font-weight: 500; src: url('{$bodyFontMedium}') format('{$format}'); }";
        }
        if (!empty($bodyFontBold)) {
            $format = $getFontFormat($bodyFontBold);
            $fontLoadingCss .= "@font-face { font-display: swap; font-family: '{$bodyFont}'; font-style: normal; font-weight: 700; src: url('{$bodyFontBold}') format('{$format}'); }";
        }
        if (!empty($bodyFontHeavy)) {
            $format = $getFontFormat($bodyFontHeavy);
            $fontLoadingCss .= "@font-face { font-display: swap; font-family: '{$bodyFont}'; font-style: normal; font-weight: 900; src: url('{$bodyFontHeavy}') format('{$format}'); }";
        }
    }
    
    // Build CSS for TinyMCE editor - use direct font-family values since editor runs in iframe
    $buttonStyles = $fontLoadingCss;
    $buttonStyles .= ".button {";
    $buttonStyles .= "font-family: '{$buttonFontFamily}', {$bodyFontFallback};";
    $buttonStyles .= "font-size: {$buttonFontSize}rem;";
    $buttonStyles .= "line-height: {$buttonLineHeight};";
    $buttonStyles .= "font-weight: {$buttonFontWeight};";
    $buttonStyles .= "text-transform: {$buttonTextTransform};";
    $buttonStyles .= "}";
    // Add heading styles for h1-h6
    $buttonStyles .= "h1, h2, h3, h4, h5, h6 {";
    $buttonStyles .= "font-family: '{$headingFont}', {$headingFontFallback};";
    $buttonStyles .= "}";
    // Add body styles
    $buttonStyles .= "body, p {";
    $buttonStyles .= "font-family: '{$bodyFont}', {$bodyFontFallback};";
    $buttonStyles .= "}";
    
    // Add custom font styles CSS to TinyMCE
    $customFontStyles = !empty($typographyOptions['customFontStyles']) 
        ? $typographyOptions['customFontStyles'] 
        : [];
    
    if (!empty($customFontStyles)) {
        foreach ($customFontStyles as $style) {
            if (empty($style['className']) || empty($style['styleName'])) {
                continue;
            }
            
            $className = esc_attr($style['className']);
            // Ensure class name starts with "font-" if it doesn't already
            if (strpos($className, 'font-') !== 0) {
                $className = 'font-' . $className;
            }
            
            $headingLevel = !empty($style['headingLevel']) 
                ? esc_attr($style['headingLevel']) 
                : '';
            
            // Get selected font family for this style
            $selectedFontFamily = !empty($style['fontFamily']) 
                ? esc_attr($style['fontFamily']) 
                : 'heading';
            
            $sizeMobile = !empty($style['sizeMobile']) 
                ? floatval($style['sizeMobile']) 
                : 1;
            $sizeDesktop = !empty($style['sizeDesktop']) 
                ? floatval($style['sizeDesktop']) 
                : $sizeMobile;
            $lineHeight = !empty($style['lineHeight']) 
                ? floatval($style['lineHeight']) 
                : 1.2;
            $fontWeight = !empty($style['fontWeight']) 
                ? esc_attr($style['fontWeight']) 
                : '400';
            $textTransform = !empty($style['textTransform']) 
                ? esc_attr($style['textTransform']) 
                : 'none';
            
            // Build selector
            $selector = '';
            if (!empty($headingLevel)) {
                $selector = "{$headingLevel}, .{$className}";
            } else {
                $selector = ".{$className}";
            }
            
            // Determine font family based on selection
            $styleFontFamily = ($selectedFontFamily === 'body') 
                ? "'{$bodyFont}', {$bodyFontFallback}"
                : "'{$headingFont}', {$headingFontFallback}";
            
            $buttonStyles .= "{$selector} {";
            $buttonStyles .= "font-family: {$styleFontFamily};";
            $buttonStyles .= "font-size: {$sizeMobile}rem;";
            $buttonStyles .= "line-height: {$lineHeight};";
            $buttonStyles .= "font-weight: {$fontWeight};";
            $buttonStyles .= "text-transform: {$textTransform};";
            $buttonStyles .= "}";
            
            // Add desktop size if different
            if ($sizeDesktop != $sizeMobile) {
                $buttonStyles .= "@media (min-width: 1024px) {";
                if (!empty($headingLevel)) {
                    $buttonStyles .= "{$headingLevel}, .{$className} {";
                } else {
                    $buttonStyles .= ".{$className} {";
                }
                $buttonStyles .= "font-size: {$sizeDesktop}rem;";
                $buttonStyles .= "}";
                $buttonStyles .= "}";
            }
        }
    }
    
    // Add custom button styles CSS to TinyMCE
    $customButtonStyles = !empty($typographyOptions['customButtonStyles']) 
        ? $typographyOptions['customButtonStyles'] 
        : [];
    
    if (!empty($customButtonStyles)) {
        foreach ($customButtonStyles as $style) {
            if (empty($style['className']) || empty($style['styleName'])) {
                continue;
            }
            
            $className = esc_attr($style['className']);
            if (strpos($className, 'button--') !== 0) {
                $className = 'button--' . $className;
            }
            
            $backgroundColor = !empty($style['backgroundColor']) 
                ? esc_attr($style['backgroundColor']) 
                : 'transparent';
            $textColor = !empty($style['textColor']) 
                ? esc_attr($style['textColor']) 
                : 'inherit';
            $borderColor = !empty($style['borderColor']) 
                ? esc_attr($style['borderColor']) 
                : '';
            $hoverBackgroundColor = !empty($style['hoverBackgroundColor']) 
                ? esc_attr($style['hoverBackgroundColor']) 
                : '';
            $hoverTextColor = !empty($style['hoverTextColor']) 
                ? esc_attr($style['hoverTextColor']) 
                : '';
            $hoverBorderColor = !empty($style['hoverBorderColor']) 
                ? esc_attr($style['hoverBorderColor']) 
                : '';
            
            // Base button styles
            $buttonStyles .= ".button.{$className} {";
            if ($backgroundColor !== 'transparent') {
                $buttonStyles .= "background-color: {$backgroundColor};";
            } else {
                $buttonStyles .= "background-color: transparent;";
            }
            $buttonStyles .= "color: {$textColor};";
            if (!empty($borderColor)) {
                $buttonStyles .= "border-color: {$borderColor};";
            }
            $buttonStyles .= "}";
            
            // Hover styles
            if (!empty($hoverBackgroundColor) || !empty($hoverTextColor) || !empty($hoverBorderColor)) {
                $buttonStyles .= ".button.{$className}:hover,";
                $buttonStyles .= ".button.{$className}:focus {";
                if (!empty($hoverBackgroundColor)) {
                    $buttonStyles .= "background-color: {$hoverBackgroundColor};";
                }
                if (!empty($hoverTextColor)) {
                    $buttonStyles .= "color: {$hoverTextColor};";
                }
                if (!empty($hoverBorderColor)) {
                    $buttonStyles .= "border-color: {$hoverBorderColor};";
                } elseif (!empty($hoverBackgroundColor) && empty($hoverBorderColor) && !empty($borderColor)) {
                    $buttonStyles .= "border-color: {$hoverBackgroundColor};";
                }
                $buttonStyles .= "}";
            }
        }
    }
    
    // Add to existing content_style or create new one
    if (!empty($init['content_style'])) {
        $init['content_style'] .= ' ' . $buttonStyles;
    } else {
        $init['content_style'] = $buttonStyles;
    }
    
    return $init;
}, 10);

// Add custom font and button styles to TinyMCE style formats
add_filter('tiny_mce_before_init', function ($init) {
    $typographyOptions = \Flynt\Utils\Options::getGlobal('Typography');
    $customFontStyles = !empty($typographyOptions['customFontStyles']) 
        ? $typographyOptions['customFontStyles'] 
        : [];
    $customButtonStyles = !empty($typographyOptions['customButtonStyles']) 
        ? $typographyOptions['customButtonStyles'] 
        : [];
    
    // Get existing style formats or initialize empty array
    $existingFormats = [];
    if (!empty($init['style_formats'])) {
        $existingFormats = json_decode($init['style_formats'], true);
        if (!is_array($existingFormats)) {
            $existingFormats = [];
        }
    }
    
    // Group custom font styles by category
    $stylesByCategory = [];
    foreach ($customFontStyles as $style) {
        if (empty($style['className']) || empty($style['styleName'])) {
            continue;
        }
        
        $className = esc_attr($style['className']);
        if (strpos($className, 'font-') !== 0) {
            $className = 'font-' . $className;
        }
        
        $category = !empty($style['category']) 
            ? esc_attr($style['category']) 
            : 'Custom';
        
        if (!isset($stylesByCategory[$category])) {
            $stylesByCategory[$category] = [];
        }
        
        // Add heading level for accessibility and SEO
        $headingLevel = !empty($style['headingLevel']) 
            ? esc_attr($style['headingLevel']) 
            : '';
        
        if (!empty($headingLevel)) {
            // When block is set, don't use selector - TinyMCE will wrap in the block element
            $styleFormat = [
                'title' => esc_attr($style['styleName']),
                'block' => $headingLevel,
                'classes' => $className,
            ];
        } else {
            // For non-block styles, use selector to apply class to any element
            $styleFormat = [
                'title' => esc_attr($style['styleName']),
                'classes' => $className,
                'selector' => '*'
            ];
        }
        
        $stylesByCategory[$category][] = $styleFormat;
    }
    
    // Group custom button styles by category
    foreach ($customButtonStyles as $style) {
        if (empty($style['className']) || empty($style['styleName'])) {
            continue;
        }
        
        $className = esc_attr($style['className']);
        if (strpos($className, 'button--') !== 0) {
            $className = 'button--' . $className;
        }
        
        $category = !empty($style['category']) 
            ? esc_attr($style['category']) 
            : 'Buttons';
        
        if (!isset($stylesByCategory[$category])) {
            $stylesByCategory[$category] = [];
        }
        
        // Button styles apply to anchor tags
        $styleFormat = [
            'title' => esc_attr($style['styleName']),
            'classes' => 'button ' . $className,
            'selector' => 'a'
        ];
        
        $stylesByCategory[$category][] = $styleFormat;
    }
    
    // Add custom style categories to existing formats
    foreach ($stylesByCategory as $category => $styles) {
        $existingFormats[] = [
            'title' => $category,
            'icon' => '',
            'items' => $styles
        ];
    }
    
    // Update TinyMCE init with merged style formats
    if (!empty($existingFormats)) {
        $init['style_formats'] = json_encode($existingFormats);
    }
    
    return $init;
}, 20);
