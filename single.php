<?php

use Timber\Timber;

$context = Timber::context();

// "Alle News" back link: the posts page if one is set, else the normal /news/ page.
$newsPageId = (int) get_option('page_for_posts');
if (!$newsPageId) {
    $newsPage = get_page_by_path('news');
    $newsPageId = $newsPage ? $newsPage->ID : 0;
}
$context['newsUrl'] = $newsPageId ? get_permalink($newsPageId) : '';

// Roots & Shoots group articles are reached from the groups page, not the news list.
if (has_category('root-shoots')) {
    $context['newsUrl'] = '';
}

Timber::render('templates/single.twig', $context);
