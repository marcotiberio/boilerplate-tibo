<?php

namespace Flynt\Components\FeatureAdminComponentScreenshots;

use Flynt\ComponentManager;

add_action('admin_enqueue_scripts', function () {
    $componentManager = ComponentManager::getInstance();
    $templateDirectory = get_template_directory();
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
        'components' => array_map(function ($componentPath) use ($templateDirectory) {
            return str_replace($templateDirectory, '', $componentPath);
        }, $componentManager->getAll()),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntComponentScreenshots', $data);
});

// Note: Screenshot functionality in layout titles is handled by FeatureFlexibleContentExtension
// This component only provides hover preview functionality via JavaScript
