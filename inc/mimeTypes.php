<?php

/**
 * Adds SVG and font files to the mime types supported (useful for gallery uploads and font uploads in the WP Backend).
 */

namespace Flynt\MimeTypes;

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    // Font file types
    $mimes['woff2'] = 'font/woff2';
    $mimes['woff'] = 'font/woff';
    $mimes['ttf'] = 'font/ttf';
    $mimes['otf'] = 'font/otf';
    return $mimes;
});
