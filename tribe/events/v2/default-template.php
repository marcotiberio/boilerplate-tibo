<?php

/**
 * The Events Calendar wrapper override: renders event views inside the theme's
 * Twig document instead of get_header()/get_footer(), which this theme does not have.
 *
 * Original: the-events-calendar/src/views/v2/default-template.php
 */

use Tribe\Events\Views\V2\Template_Bootstrap;
use Timber\Timber;

$context = Timber::context();
$context['eventsHtml'] = tribe(Template_Bootstrap::class)->get_view_html();

Timber::render('templates/tribe-events.twig', $context);
