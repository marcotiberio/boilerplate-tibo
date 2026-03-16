<?php

use Timber\Timber;
use Flynt\Utils\Options;

$context = Timber::context();
$context['backButtonLabel'] = Options::getTranslatable('Articles', 'backButtonLabel') ?: 'Zurück';

Timber::render('templates/single-author.twig', $context);
