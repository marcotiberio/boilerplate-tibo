<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this theme. We'll require it here so we don't have to manually load
| our classes.
|
*/

if (! file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| Boot Acorn and register the application to handle requests.
|
*/

if (! function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
        ]
    );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Theme Setup
|--------------------------------------------------------------------------
|
| Load block registrations, field groups, View Composers, and asset
| enqueuing. This is the main setup file for the theme.
|
*/

require_once __DIR__ . '/app/setup.php';

/*
|--------------------------------------------------------------------------
| Register Menus
|--------------------------------------------------------------------------
*/

add_action('after_setup_theme', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'sage'),
        'navigation_footer' => __('Navigation Footer', 'sage'),
    ]);

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);
    add_theme_support('editor-styles');
});

/*
|--------------------------------------------------------------------------
| Register ACF Blocks
|--------------------------------------------------------------------------
*/

add_action('init', function () {
    if (function_exists('acf_register_block_type')) {
        \App\Blocks\register_all_blocks();
    }
});
