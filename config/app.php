<?php

/**
 * Acorn application configuration.
 */

return [
    'name' => env('APP_NAME', 'Sage'),
    'debug' => env('WP_DEBUG', false),

    'providers' => [
        /*
         * Acorn Service Providers
         */
        Roots\Acorn\Assets\AssetsServiceProvider::class,
        Roots\Acorn\Filesystem\FilesystemServiceProvider::class,
        Roots\Acorn\View\ViewServiceProvider::class,

        /*
         * Theme Service Providers
         */
        // App\Providers\ThemeServiceProvider::class,
    ],
];
