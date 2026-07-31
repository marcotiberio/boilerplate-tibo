<?php

namespace Flynt\Components\HighlightCard;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=HighlightCard', function ($data) {
    $options = Options::getTranslatable('HighlightCard');
    $data['active'] = $options['active'] ?? false;
    $data['image'] = $options['image'] ?? null;
    $data['title'] = $options['title'] ?? '';
    $data['link'] = $options['link'] ?? null;

    return $data;
});

Options::addTranslatable('HighlightCard', [
    [
        'label' => __('Enable Highlight Card', 'flynt'),
        'instructions' => __('Show a dismissible promo card fixed to the bottom-right corner on every page.', 'flynt'),
        'name' => 'active',
        'type' => 'true_false',
        'ui' => 1,
    ],
    [
        'label' => __('Image', 'flynt'),
        'instructions' => __('Image-Format: JPG, PNG, SVG, WEBP.', 'flynt'),
        'name' => 'image',
        'type' => 'image',
        'preview_size' => 'medium',
        'return_format' => 'array',
        'required' => 0,
        'mime_types' => 'jpg,jpeg,png,svg,webp',
    ],
    [
        'label' => __('Title', 'flynt'),
        'instructions' => __('Maximum 75 characters.', 'flynt'),
        'name' => 'title',
        'type' => 'text',
        'required' => 0,
        'maxlength' => 25,
    ],
    [
        'label' => __('Link', 'flynt'),
        'name' => 'link',
        'type' => 'link',
        'return_format' => 'array',
        'required' => 0,
    ],
]);
