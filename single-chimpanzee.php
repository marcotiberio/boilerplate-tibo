<?php

use Timber\Timber;

use function Flynt\FieldGroups\Chimpanzee\getEmbedScript;

$context = Timber::context();

// Embed markup for this chimpanzee's sponsorship form, composed from its
// fields — see inc/fieldGroups/chimpanzeeComponents.php.
$context['embedScript'] = getEmbedScript(get_the_ID());

Timber::render('templates/single-chimpanzee.twig', $context);
