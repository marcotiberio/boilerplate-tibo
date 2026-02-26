<?php

/**
 * Theme setup.
 *
 * Loaded by Acorn via functions.php bootloader.
 * Registers block fields and View Composers.
 */

namespace App;

// Load ACF block field registrations
require_once __DIR__ . '/Blocks/register.php';
require_once __DIR__ . '/Blocks/Fields/register-fields.php';

// Load View Composers
require_once __DIR__ . '/View/Composers/Header.php';
require_once __DIR__ . '/View/Composers/Footer.php';

/**
 * Register a custom block category for our theme blocks.
 */
add_filter('block_categories_all', function (array $categories): array {
    array_unshift($categories, [
        'slug' => 'theme-blocks',
        'title' => __('Theme Blocks', 'sage'),
        'icon' => 'layout',
    ]);

    return $categories;
});

/**
 * Enqueue Vite assets.
 */
add_action('wp_enqueue_scripts', function () {
    $manifest_path = get_theme_file_path('public/.vite/manifest.json');

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);

        // Main CSS
        if (isset($manifest['resources/scripts/main.js']['css'])) {
            foreach ($manifest['resources/scripts/main.js']['css'] as $css) {
                wp_enqueue_style('sage-main', get_theme_file_uri("public/{$css}"), [], null);
            }
        }

        // Main JS
        if (isset($manifest['resources/scripts/main.js']['file'])) {
            wp_enqueue_script(
                'sage-main',
                get_theme_file_uri("public/{$manifest['resources/scripts/main.js']['file']}"),
                [],
                null,
                true
            );
        }
    } else {
        // Dev mode: load from Vite dev server
        wp_enqueue_script('vite-client', 'http://localhost:5173/@vite/client', [], null, false);
        wp_enqueue_script('sage-main', 'http://localhost:5173/resources/scripts/main.js', [], null, true);
    }
});

/**
 * Enqueue editor styles for block previews in Gutenberg.
 */
add_action('enqueue_block_editor_assets', function () {
    $manifest_path = get_theme_file_path('public/.vite/manifest.json');

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), true);

        if (isset($manifest['resources/scripts/editor.js']['css'])) {
            foreach ($manifest['resources/scripts/editor.js']['css'] as $css) {
                wp_enqueue_style('sage-editor', get_theme_file_uri("public/{$css}"), [], null);
            }
        }
    }
});
