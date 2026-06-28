<?php

use Timber\Timber;
use Flynt\ProgramEntry;

$context = Timber::context();
$post = $context['post'];

// Resolve stored choice keys to their human labels.
$config = ProgramEntry\getConfig();

$mapLabels = function ($keys, $choices) {
    return array_map(function ($key) use ($choices) {
        return $choices[$key] ?? $key;
    }, (array) ($keys ?: []));
};
$singleLabel = function ($key, $choices) use ($post) {
    $value = $post->meta($key);
    return $choices[$value] ?? $value;
};

$context['labels'] = [
    'goals'         => $mapLabels($post->meta('goals'), $config['goals']),
    'sectors'       => $mapLabels($post->meta('sectors'), $config['sectors']),
    'programTypes'  => $mapLabels($post->meta('programTypes'), $config['programTypes']),
    'audiences'     => $mapLabels($post->meta('audiences'), $config['audiences']),
    'accessibility' => $mapLabels($post->meta('accessibility'), $config['accessibility']),
    'registration'  => $singleLabel('registration', $config['registration']),
    'costs'         => $singleLabel('costs', $config['costs']),
    'format'        => $singleLabel('format', $config['format']),
    'dateMode'      => $singleLabel('dateMode', $config['dateMode']),
    'locationMode'  => $singleLabel('locationMode', $config['locationMode']),
];

// Image fields are stored as attachment IDs.
$logoId = $post->meta('orgLogo');
$context['orgLogoUrl'] = $logoId ? wp_get_attachment_image_url($logoId, 'medium') : '';

$galleryIds = $post->meta('gallery') ?: [];
$context['galleryUrls'] = array_values(array_filter(array_map(function ($id) {
    return wp_get_attachment_image_url($id, 'medium');
}, (array) $galleryIds)));

Timber::render('templates/single-program-entry.twig', $context);
