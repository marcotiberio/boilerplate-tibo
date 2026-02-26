<?php

/**
 * View configuration
 */

return [
    'paths' => [
        get_theme_file_path('/resources/views'),
    ],

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        wp_upload_dir()['basedir'] . '/cache/acorn/framework/views'
    ),

    'namespaces' => [],
];
