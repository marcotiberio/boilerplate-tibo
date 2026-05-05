<?php

use Flynt\Utils\Options;
use Timber\Timber;

$context = Timber::context();
$context['singleProject'] = Options::getTranslatable('SingleProject');

Timber::render('templates/single.twig', $context);
