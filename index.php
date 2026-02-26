<?php

/**
 * WordPress template hierarchy fallback.
 * Sage uses Blade templates via Acorn, but WordPress requires
 * at least index.php in the theme root.
 */

// Load Blade template
if (function_exists('\Roots\view')) {
    echo \Roots\view('index')->render();
} else {
    get_template_part('resources/views/index');
}
