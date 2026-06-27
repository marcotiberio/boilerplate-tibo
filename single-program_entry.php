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

$context['goalLabels']         = $mapLabels($post->meta('goals'), $config['goals']);
$context['sectorLabels']       = $mapLabels($post->meta('sectors'), $config['sectors']);
$context['programTypeLabels']  = $mapLabels($post->meta('programTypes'), $config['programTypes']);
$context['audienceLabels']     = $mapLabels($post->meta('audiences'), $config['audiences']);
$context['accessibilityLabels'] = $mapLabels($post->meta('accessibility'), $config['accessibility']);
$context['formatLabel']        = $config['format'][$post->meta('format')] ?? $post->meta('format');

Timber::render('templates/single-program-entry.twig', $context);
