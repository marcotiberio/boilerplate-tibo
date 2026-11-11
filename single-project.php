<?php

/**
 * Project detail pages are built from page components, like pages.
 */

use Timber\Timber;

$context = Timber::context();

Timber::render('templates/page.twig', $context);
