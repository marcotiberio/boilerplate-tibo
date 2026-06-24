<?php

use Timber\Timber;
use Flynt\ProgramEntry;

$context = Timber::context();
$post = $context['post'];

// Resolve the stored choice keys to their human labels.
$config = ProgramEntry\getConfig();

$categoryKey = $post->meta('category');
$context['categoryLabel'] = $config['categories'][$categoryKey] ?? $categoryKey;

$themeKeys = $post->meta('themes') ?: [];
$context['themeLabels'] = array_map(function ($key) use ($config) {
    return $config['themes'][$key] ?? $key;
}, $themeKeys);

Timber::render('templates/single-program-entry.twig', $context);
