<?php

use Timber\Timber;
use Flynt\Utils\Options;

$context = Timber::context();
$context['authorLabel'] = Options::getTranslatable('Articles', 'authorLabel') ?: 'Ein Artikel von';
$context['backButtonLabel'] = Options::getTranslatable('Articles', 'backButtonLabel') ?: 'Zurück';

Timber::render('templates/single.twig', $context);
