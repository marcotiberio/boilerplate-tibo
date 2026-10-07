<?php

namespace Flynt\Components\FeatureAdminComponentScreenshots;

use Flynt\ComponentManager;

add_action('admin_enqueue_scripts', function (): void {
    $componentManager = ComponentManager::getInstance();
    $templateDirectory = get_template_directory();
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
        'version' => wp_get_theme()->get('Version'),
        'components' => array_map(function ($componentPath) use ($templateDirectory) {
            return str_replace($templateDirectory, '', $componentPath);
        }, $componentManager->getAll()),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntComponentScreenshots', $data);
});

// add image to the flexible content component name
// runs for clones too ($order = 'acfcloneindex'), so newly added layouts get the thumbnail
add_filter('acf/fields/flexible_content/layout_title', function (string $title, array $field, array $layout, $order): string {
    $componentManager = ComponentManager::getInstance();
    $componentName = ucfirst($layout['name']);
    $componentPathFull = $componentManager->getComponentDirPath($componentName);
    $componentPath = str_replace(get_template_directory(), '', $componentPathFull);
    $templateDirectoryUri = get_template_directory_uri();
    $componentScreenshotPath = "{$componentPathFull}/screenshot.png";
    $componentScreenshotUrl = "{$templateDirectoryUri}/{$componentPath}/screenshot.png?v=" . wp_get_theme()->get('Version');

    $newTitle = '<span class="flyntComponentScreenshot">';

    if (is_file($componentScreenshotPath)) {
        $imageSize = getimagesize($componentScreenshotPath);
        $newTitle .= sprintf(
            '<img class="flyntComponentScreenshot-previewImageSmall" width="%s" height="%s" src="%s" loading="lazy">',
            $imageSize[0],
            $imageSize[1],
            $componentScreenshotUrl
        );
    }

    $newTitle .= sprintf('<span class="flyntComponentScreenshot-label">%s</span>', $title);
    $newTitle .= '</span>';

    return html_entity_decode($newTitle);
}, 11, 4);
