<?php

namespace Flynt\Typography;

use Flynt\Utils\Options;

add_action('acf/init', function () {
    // Add Typography fields to Global Options
    Options::addGlobal('Typography', [
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
        [
            'label' => __('Heading 1 - Size (Mobile)', 'flynt'),
            'instructions' => __('H1 font size in rem for mobile devices.', 'flynt'),
            'name' => 'h1SizeMobile',
            'type' => 'number',
            'default_value' => 2.25,
            'min' => 1,
            'max' => 6,
            'step' => 0.25,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Heading 1 - Size (Desktop)', 'flynt'),
            'instructions' => __('H1 font size in rem for desktop devices.', 'flynt'),
            'name' => 'h1SizeDesktop',
            'type' => 'number',
            'default_value' => 3.25,
            'min' => 1,
            'max' => 8,
            'step' => 0.25,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Heading 1 - Line Height', 'flynt'),
            'instructions' => __('H1 line height (unitless value, e.g., 1.2).', 'flynt'),
            'name' => 'h1LineHeight',
            'type' => 'number',
            'default_value' => 1.2,
            'min' => 0.8,
            'max' => 2,
            'step' => 0.1,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Heading 2 - Size (Mobile)', 'flynt'),
            'instructions' => __('H2 font size in rem for mobile devices.', 'flynt'),
            'name' => 'h2SizeMobile',
            'type' => 'number',
            'default_value' => 1.75,
            'min' => 1,
            'max' => 5,
            'step' => 0.25,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Heading 2 - Size (Desktop)', 'flynt'),
            'instructions' => __('H2 font size in rem for desktop devices.', 'flynt'),
            'name' => 'h2SizeDesktop',
            'type' => 'number',
            'default_value' => 2,
            'min' => 1,
            'max' => 6,
            'step' => 0.25,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Heading 2 - Line Height', 'flynt'),
            'instructions' => __('H2 line height (unitless value, e.g., 1.2).', 'flynt'),
            'name' => 'h2LineHeight',
            'type' => 'number',
            'default_value' => 1.2,
            'min' => 0.8,
            'max' => 2,
            'step' => 0.1,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Body Text - Size (Mobile)', 'flynt'),
            'instructions' => __('Body text font size in rem for mobile devices.', 'flynt'),
            'name' => 'bodySizeMobile',
            'type' => 'number',
            'default_value' => 1.25,
            'min' => 0.75,
            'max' => 2,
            'step' => 0.25,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Body Text - Size (Desktop)', 'flynt'),
            'instructions' => __('Body text font size in rem for desktop devices.', 'flynt'),
            'name' => 'bodySizeDesktop',
            'type' => 'number',
            'default_value' => 1.25,
            'min' => 0.75,
            'max' => 2.5,
            'step' => 0.25,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Body Text - Line Height', 'flynt'),
            'instructions' => __('Body text line height (unitless value, e.g., 1.2).', 'flynt'),
            'name' => 'bodyLineHeight',
            'type' => 'number',
            'default_value' => 1.2,
            'min' => 0.8,
            'max' => 2,
            'step' => 0.1,
            'wrapper' => [
                'width' => 33,
            ],
        ],
        [
            'label' => __('Body Small - Size', 'flynt'),
            'instructions' => __('Small body text font size in rem.', 'flynt'),
            'name' => 'bodySmallSize',
            'type' => 'number',
            'default_value' => 0.75,
            'min' => 0.5,
            'max' => 1.5,
            'step' => 0.125,
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Body Small - Line Height', 'flynt'),
            'instructions' => __('Body small text line height (unitless value, e.g., 1.2).', 'flynt'),
            'name' => 'bodySmallLineHeight',
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
            'label' => __('Menu - Font Size', 'flynt'),
            'instructions' => __('Menu/navigation font size in rem.', 'flynt'),
            'name' => 'menuSize',
            'type' => 'number',
            'default_value' => 1,
            'min' => 0.75,
            'max' => 2,
            'step' => 0.125,
            'wrapper' => [
                'width' => 50,
            ],
        ],
        [
            'label' => __('Menu - Line Height', 'flynt'),
            'instructions' => __('Menu/navigation line height (unitless value, e.g., 1.2).', 'flynt'),
            'name' => 'menuLineHeight',
            'type' => 'number',
            'default_value' => 1.2,
            'min' => 0.8,
            'max' => 2,
            'step' => 0.1,
            'wrapper' => [
                'width' => 50,
            ],
        ],
    ], 'Typography');
});

// Output dynamic CSS variables based on ACF options
add_action('wp_head', function () {
    $typographyOptions = Options::getGlobal('Typography');
    
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
    $h1SizeMobile = !empty($typographyOptions['h1SizeMobile']) 
        ? floatval($typographyOptions['h1SizeMobile']) 
        : 2.25;
    $h1SizeDesktop = !empty($typographyOptions['h1SizeDesktop']) 
        ? floatval($typographyOptions['h1SizeDesktop']) 
        : 3.25;
    $h2SizeMobile = !empty($typographyOptions['h2SizeMobile']) 
        ? floatval($typographyOptions['h2SizeMobile']) 
        : 1.75;
    $h2SizeDesktop = !empty($typographyOptions['h2SizeDesktop']) 
        ? floatval($typographyOptions['h2SizeDesktop']) 
        : 2;
    $bodySizeMobile = !empty($typographyOptions['bodySizeMobile']) 
        ? floatval($typographyOptions['bodySizeMobile']) 
        : 1.25;
    $bodySizeDesktop = !empty($typographyOptions['bodySizeDesktop']) 
        ? floatval($typographyOptions['bodySizeDesktop']) 
        : 1.25;
    $bodySmallSize = !empty($typographyOptions['bodySmallSize']) 
        ? floatval($typographyOptions['bodySmallSize']) 
        : 0.75;
    $menuSize = !empty($typographyOptions['menuSize']) 
        ? floatval($typographyOptions['menuSize']) 
        : 1;
    $h1LineHeight = !empty($typographyOptions['h1LineHeight']) 
        ? floatval($typographyOptions['h1LineHeight']) 
        : 1.2;
    $h2LineHeight = !empty($typographyOptions['h2LineHeight']) 
        ? floatval($typographyOptions['h2LineHeight']) 
        : 1.2;
    $bodyLineHeight = !empty($typographyOptions['bodyLineHeight']) 
        ? floatval($typographyOptions['bodyLineHeight']) 
        : 1.2;
    $bodySmallLineHeight = !empty($typographyOptions['bodySmallLineHeight']) 
        ? floatval($typographyOptions['bodySmallLineHeight']) 
        : 1.2;
    $menuLineHeight = !empty($typographyOptions['menuLineHeight']) 
        ? floatval($typographyOptions['menuLineHeight']) 
        : 1.2;
    
    // Build CSS variables
    $css = ":root {\n";
    $css .= "  --primary-font-family: '{$primaryFont}', {$primaryFontFallback};\n";
    $css .= "  --base-font-size-mobile: {$baseFontSizeMobile}px;\n";
    $css .= "  --base-font-size-desktop: {$baseFontSizeDesktop}px;\n";
    $css .= "  --h1-size-mobile: {$h1SizeMobile}rem;\n";
    $css .= "  --h1-size-desktop: {$h1SizeDesktop}rem;\n";
    $css .= "  --h1-line-height: {$h1LineHeight};\n";
    $css .= "  --h2-size-mobile: {$h2SizeMobile}rem;\n";
    $css .= "  --h2-size-desktop: {$h2SizeDesktop}rem;\n";
    $css .= "  --h2-line-height: {$h2LineHeight};\n";
    $css .= "  --body-size-mobile: {$bodySizeMobile}rem;\n";
    $css .= "  --body-size-desktop: {$bodySizeDesktop}rem;\n";
    $css .= "  --body-line-height: {$bodyLineHeight};\n";
    $css .= "  --body-small-size: {$bodySmallSize}rem;\n";
    $css .= "  --body-small-line-height: {$bodySmallLineHeight};\n";
    $css .= "  --menu-size: {$menuSize}rem;\n";
    $css .= "  --menu-line-height: {$menuLineHeight};\n";
    $css .= "}\n";
    
    echo "<style id='flynt-typography-css'>\n{$css}\n</style>\n";
}, 100);

