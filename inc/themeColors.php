<?php

/**
 * Theme color integration
 *
 * Reads the color palette from theme.json and injects it into:
 *   - the block editor (editor-color-palette)
 *   - the ACF color picker (wpColorPicker palettes)
 */

namespace Flynt\ThemeColors;

/**
 * Return the theme.json color palette.
 *
 * Tries WP_Theme_JSON_Resolver first; falls back to reading theme.json
 * directly so a stale resolver cache or other early-bootstrap edge case
 * cannot leave us with an empty palette.
 *
 * @return array<int, array{slug: string, color: string, name: string}>
 */
function getThemeJsonPalette()
{
    static $palette = null;

    if ($palette !== null) {
        return $palette;
    }

    if (class_exists('WP_Theme_JSON_Resolver')) {
        $settings = \WP_Theme_JSON_Resolver::get_theme_data()->get_settings();
        if (!empty($settings['color']['palette']['theme'])) {
            $palette = $settings['color']['palette']['theme'];
            return $palette;
        }
    }

    $file = get_template_directory() . '/theme.json';
    if (is_readable($file)) {
        $data = json_decode(file_get_contents($file), true);
        if (!empty($data['settings']['color']['palette'])) {
            $palette = $data['settings']['color']['palette'];
            return $palette;
        }
    }

    $palette = [];
    return $palette;
}

/**
 * Register the theme.json palette as the block editor palette.
 */
add_action('after_setup_theme', function () {
    $palette = getThemeJsonPalette();
    if (empty($palette)) {
        return;
    }

    add_theme_support('editor-color-palette', array_map(function ($color) {
        return [
            'name'  => $color['name'],
            'slug'  => $color['slug'],
            'color' => $color['color'],
        ];
    }, $palette));
}, 20);

/**
 * Inject the theme palette into ACF's color picker.
 *
 * ACF wraps wpColorPicker (Iris). The `color_picker_args` JS filter lets us
 * pass `palettes` as an array of hex strings, which Iris renders as swatches
 * underneath the picker. Priority 20 so we run after any other plugin
 * (e.g. acf-restrict-color-picker) that hooks the same filter at default 10.
 */
add_action('acf/input/admin_enqueue_scripts', function () {
    $palette = getThemeJsonPalette();
    if (empty($palette)) {
        return;
    }

    $hexValues = array_values(array_map(function ($color) {
        return $color['color'];
    }, $palette));

    $js = sprintf(
        '(function(){if(typeof acf==="undefined"){console.warn("[Flynt] ACF not available for color picker palette injection");return;}var palette=%s;acf.add_filter("color_picker_args",function(args){args.palettes=palette;return args;},20);})();',
        wp_json_encode($hexValues)
    );

    wp_add_inline_script('acf-input', $js, 'after');
}, 999);
