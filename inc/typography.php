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
            'label' => __('Font Source', 'flynt'),
            'instructions' => __('Choose how to load the font: Google Fonts or upload custom font files.', 'flynt'),
            'name' => 'fontSource',
            'type' => 'select',
            'choices' => [
                'google' => 'Google Fonts',
                'custom' => 'Custom Upload',
            ],
            'default_value' => 'google',
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => __('Google Fonts URL', 'flynt'),
            'instructions' => __('Paste the Google Fonts link URL here. Example: https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap', 'flynt'),
            'name' => 'googleFontsUrl',
            'type' => 'url',
            'placeholder' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'fontSource',
                        'operator' => '==',
                        'value' => 'google',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 100,
            ],
        ],
        [
            'label' => __('Custom Font - Medium (500)', 'flynt'),
            'instructions' => __('Upload the medium weight font file (woff2 format recommended).', 'flynt'),
            'name' => 'customFontMedium',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'fontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Custom Font - Bold (700)', 'flynt'),
            'instructions' => __('Upload the bold weight font file (woff2 format recommended).', 'flynt'),
            'name' => 'customFontBold',
            'type' => 'file',
            'return_format' => 'url',
            'library' => 'all',
            'mime_types' => 'woff2,woff,ttf,otf',
            'conditional_logic' => [
                [
                    [
                        'fieldPath' => 'fontSource',
                        'operator' => '==',
                        'value' => 'custom',
                    ],
                ],
            ],
            'wrapper' => [
                'width' => 50,
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
            'instructions' => __('Select the primary font family for body text and headings.', 'flynt'),
            'name' => 'primaryFontFamily',
            'type' => 'text',
            'default_value' => 'Inter',
            'placeholder' => 'Inter',
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Primary Font Fallback', 'flynt'),
            'instructions' => __('Fallback fonts (e.g., Arial, sans-serif)', 'flynt'),
            'name' => 'primaryFontFallback',
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
            'layout' => 'block',
            'button_label' => __('Add Font Style', 'flynt'),
            'sub_fields' => [
                [
                    'label' => __('Style Name', 'flynt'),
                    'instructions' => __('Display name for this style (shown in editor dropdown)', 'flynt'),
                    'name' => 'styleName',
                    'type' => 'text',
                    'required' => 1,
                    'wrapper' => [
                        'width' => 33,
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
                        'width' => 33,
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
                        'width' => 33,
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
                        'width' => 50,
                    ],
                ],
                [
                    'label' => __('Font Size (Desktop)', 'flynt'),
                    'instructions' => __('Font size in rem for desktop devices.', 'flynt'),
                    'name' => 'sizeDesktop',
                    'type' => 'number',
                    'default_value' => 1.25,
                    'min' => 0.5,
                    'max' => 10,
                    'step' => 0.125,
                    'wrapper' => [
                        'width' => 50,
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
                        'width' => 50,
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
                        '600' => '600 (Semi-Bold)',
                        '700' => '700 (Bold)',
                    ],
                    'default_value' => '400',
                    'wrapper' => [
                        'width' => 50,
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
                        'width' => 50,
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
                    'instructions' => __('Leave empty to use primary font.', 'flynt'),
                    'name' => 'fontFamily',
                    'type' => 'text',
                    'placeholder' => 'Leave empty to use primary font',
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
                        '600' => '600 (Semi-Bold)',
                        '700' => '700 (Bold)',
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
            'layout' => 'block',
            'button_label' => __('Add Button Style', 'flynt'),
            'sub_fields' => [
                [
                    'label' => __('Style Name', 'flynt'),
                    'instructions' => __('Display name for this style (shown in editor dropdown)', 'flynt'),
                    'name' => 'styleName',
                    'type' => 'text',
                    'required' => 1,
                    'wrapper' => [
                        'width' => 50,
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
                        'width' => 50,
                    ],
                ],
                [
                    'label' => __('Background Color', 'flynt'),
                    'instructions' => __('Button background color (hex, rgb, or CSS variable like var(--blue))', 'flynt'),
                    'name' => 'backgroundColor',
                    'type' => 'text',
                    'default_value' => 'var(--blue)',
                    'placeholder' => 'var(--blue) or #3d6bff',
                    'wrapper' => [
                        'width' => 33,
                    ],
                ],
                [
                    'label' => __('Text Color', 'flynt'),
                    'instructions' => __('Button text color (hex, rgb, or CSS variable)', 'flynt'),
                    'name' => 'textColor',
                    'type' => 'text',
                    'default_value' => 'var(--beige)',
                    'placeholder' => 'var(--beige) or #ffffff',
                    'wrapper' => [
                        'width' => 33,
                    ],
                ],
                [
                    'label' => __('Border Color', 'flynt'),
                    'instructions' => __('Button border color (hex, rgb, or CSS variable). Leave empty for no border.', 'flynt'),
                    'name' => 'borderColor',
                    'type' => 'text',
                    'placeholder' => 'var(--blue) or #3d6bff',
                    'wrapper' => [
                        'width' => 33,
                    ],
                ],
                [
                    'label' => __('Hover Background Color', 'flynt'),
                    'instructions' => __('Button background color on hover (hex, rgb, or CSS variable)', 'flynt'),
                    'name' => 'hoverBackgroundColor',
                    'type' => 'text',
                    'placeholder' => 'var(--blueDark) or #1545de',
                    'wrapper' => [
                        'width' => 33,
                    ],
                ],
                [
                    'label' => __('Hover Text Color', 'flynt'),
                    'instructions' => __('Button text color on hover (hex, rgb, or CSS variable)', 'flynt'),
                    'name' => 'hoverTextColor',
                    'type' => 'text',
                    'placeholder' => 'var(--beige) or #ffffff',
                    'wrapper' => [
                        'width' => 33,
                    ],
                ],
                [
                    'label' => __('Hover Border Color', 'flynt'),
                    'instructions' => __('Button border color on hover (hex, rgb, or CSS variable). Leave empty to use hover background color.', 'flynt'),
                    'name' => 'hoverBorderColor',
                    'type' => 'text',
                    'placeholder' => 'var(--blueDark) or #1545de',
                    'wrapper' => [
                        'width' => 33,
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
                        'width' => 50,
                    ],
                ],
            ],
        ],
    ], 'Typography');
});

// Output dynamic CSS variables based on ACF options
add_action('wp_head', function () {
    $typographyOptions = Options::getGlobal('Typography');
    
    // Handle font loading (Google Fonts or Custom Upload)
    $fontSource = !empty($typographyOptions['fontSource']) 
        ? esc_attr($typographyOptions['fontSource']) 
        : 'google';
    
    if ($fontSource === 'google') {
        // Load Google Fonts
        $googleFontsUrl = !empty($typographyOptions['googleFontsUrl']) 
            ? esc_url($typographyOptions['googleFontsUrl']) 
            : '';
        
        if (!empty($googleFontsUrl)) {
            echo "<link rel='preconnect' href='https://fonts.googleapis.com'>\n";
            echo "<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>\n";
            echo "<link id='flynt-google-fonts' href='" . esc_url($googleFontsUrl) . "' rel='stylesheet'>\n";
        }
    } elseif ($fontSource === 'custom') {
        // Load custom fonts via @font-face
        // Handle different ACF return formats (url, array, or ID)
        $customFontMedium = '';
        $customFontBold = '';
        
        // Get Medium font URL
        if (!empty($typographyOptions['customFontMedium'])) {
            if (is_array($typographyOptions['customFontMedium'])) {
                $customFontMedium = !empty($typographyOptions['customFontMedium']['url']) 
                    ? esc_url($typographyOptions['customFontMedium']['url']) 
                    : '';
            } elseif (is_numeric($typographyOptions['customFontMedium'])) {
                $customFontMedium = esc_url(wp_get_attachment_url($typographyOptions['customFontMedium']));
            } else {
                $customFontMedium = esc_url($typographyOptions['customFontMedium']);
            }
        }
        
        // Get Bold font URL
        if (!empty($typographyOptions['customFontBold'])) {
            if (is_array($typographyOptions['customFontBold'])) {
                $customFontBold = !empty($typographyOptions['customFontBold']['url']) 
                    ? esc_url($typographyOptions['customFontBold']['url']) 
                    : '';
            } elseif (is_numeric($typographyOptions['customFontBold'])) {
                $customFontBold = esc_url(wp_get_attachment_url($typographyOptions['customFontBold']));
            } else {
                $customFontBold = esc_url($typographyOptions['customFontBold']);
            }
        }
        
        $primaryFont = !empty($typographyOptions['primaryFontFamily']) 
            ? esc_attr($typographyOptions['primaryFontFamily']) 
            : 'Retail';
        
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
        
        if (!empty($customFontMedium) || !empty($customFontBold)) {
            $fontFaceCss = "<style id='flynt-custom-fonts'>\n";
            
            if (!empty($customFontMedium)) {
                $format = $getFontFormat($customFontMedium);
                $fontFaceCss .= "@font-face {\n";
                $fontFaceCss .= "  font-display: swap;\n";
                $fontFaceCss .= "  font-family: '{$primaryFont}';\n";
                $fontFaceCss .= "  font-style: normal;\n";
                $fontFaceCss .= "  font-weight: 500;\n";
                $fontFaceCss .= "  src: url('{$customFontMedium}') format('{$format}');\n";
                $fontFaceCss .= "}\n\n";
            }
            
            if (!empty($customFontBold)) {
                $format = $getFontFormat($customFontBold);
                $fontFaceCss .= "@font-face {\n";
                $fontFaceCss .= "  font-display: swap;\n";
                $fontFaceCss .= "  font-family: '{$primaryFont}';\n";
                $fontFaceCss .= "  font-style: normal;\n";
                $fontFaceCss .= "  font-weight: 700;\n";
                $fontFaceCss .= "  src: url('{$customFontBold}') format('{$format}');\n";
                $fontFaceCss .= "}\n";
            }
            
            $fontFaceCss .= "</style>\n";
            echo $fontFaceCss;
        }
    }
    
    // Get values with fallbacks
    $primaryFont = !empty($typographyOptions['primaryFontFamily']) 
        ? esc_attr($typographyOptions['primaryFontFamily']) 
        : 'Inter';
    $primaryFontFallback = !empty($typographyOptions['primaryFontFallback']) 
        ? esc_attr($typographyOptions['primaryFontFallback']) 
        : 'Arial, sans-serif';
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
        : $primaryFont;
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
    
    // Build CSS variables
    $css = ":root {\n";
    $css .= "  --primary-font-family: '{$primaryFont}', {$primaryFontFallback};\n";
    $css .= "  --button-font-family: '{$buttonFontFamily}', {$primaryFontFallback};\n";
    $css .= "  --button-font-size: {$buttonFontSize}rem;\n";
    $css .= "  --button-line-height: {$buttonLineHeight};\n";
    $css .= "  --button-font-weight: {$buttonFontWeight};\n";
    $css .= "  --button-text-transform: {$buttonTextTransform};\n";
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
            
            // Build selector: include HTML tag if heading level is set
            $selector = '';
            if (!empty($headingLevel)) {
                // Target both the HTML tag and the class for better compatibility
                $selector = "{$headingLevel}, .{$className}";
            } else {
                // Just target the class
                $selector = ".{$className}";
            }
            
            $customStylesCss .= "{$selector} {\n";
            $customStylesCss .= "  font-family: var(--primary-font-family, '{$primaryFont}', {$primaryFontFallback});\n";
            $customStylesCss .= "  font-size: {$sizeMobile}rem;\n";
            $customStylesCss .= "  line-height: {$lineHeight};\n";
            $customStylesCss .= "  font-weight: {$fontWeight};\n";
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
    
    // Get button font style settings
    $buttonFontStyle = !empty($typographyOptions['buttonFontStyle']) 
        ? $typographyOptions['buttonFontStyle'] 
        : [];
    $primaryFont = !empty($typographyOptions['primaryFontFamily']) 
        ? esc_attr($typographyOptions['primaryFontFamily']) 
        : 'Inter';
    $primaryFontFallback = !empty($typographyOptions['primaryFontFallback']) 
        ? esc_attr($typographyOptions['primaryFontFallback']) 
        : 'Arial, sans-serif';
    
    $buttonFontFamily = !empty($buttonFontStyle['fontFamily']) 
        ? esc_attr($buttonFontStyle['fontFamily']) 
        : $primaryFont;
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
    
    // Build CSS for TinyMCE editor - button base styles
    $buttonStyles = ":root {";
    $buttonStyles .= "--button-font-family: '{$buttonFontFamily}', {$primaryFontFallback};";
    $buttonStyles .= "--button-font-size: {$buttonFontSize}rem;";
    $buttonStyles .= "--button-line-height: {$buttonLineHeight};";
    $buttonStyles .= "--button-font-weight: {$buttonFontWeight};";
    $buttonStyles .= "--button-text-transform: {$buttonTextTransform};";
    $buttonStyles .= "}";
    $buttonStyles .= ".button {";
    $buttonStyles .= "font-family: var(--button-font-family, '{$primaryFont}', {$primaryFontFallback});";
    $buttonStyles .= "font-size: var(--button-font-size, {$buttonFontSize}rem);";
    $buttonStyles .= "line-height: var(--button-line-height, {$buttonLineHeight});";
    $buttonStyles .= "font-weight: var(--button-font-weight, {$buttonFontWeight});";
    $buttonStyles .= "text-transform: var(--button-text-transform, {$buttonTextTransform});";
    $buttonStyles .= "}";
    
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
