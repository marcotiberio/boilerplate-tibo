<?php

use Timber\Timber;

// Prevent direct access to overlay posts - they should only be accessed via overlay
if (!wp_doing_ajax() && !isset($_GET['overlay'])) {
    // Return 404 status and render 404 template
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    $context = Timber::context();
    Timber::render('templates/404.twig', $context);
    exit;
}

$context = Timber::context();

Timber::render('templates/single-author.twig', $context);
