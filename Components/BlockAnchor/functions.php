<?php

namespace Flynt\Components\BlockAnchor;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockAnchor', function ($data) {
    if (isset($data['anchor'])) {
        $data['anchor'] = preg_replace('/[^A-Za-z0-9]/', '-', strtolower($data['anchor']));
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockAnchor',
        'label' => __('Block: Anchor', 'flynt'),
        'sub_fields' => [
            [
                [
                    'label' => __('Enter unique anchor name', 'flynt'),
                    'instructions' => __('Enter a unique name to create an anchor link.', 'flynt'),
                    'name' => 'anchor',
                    'type' => 'text',
                    'required' => 1,
                ],
                [
                    'label' => __('Anchor link', 'flynt'),
                    'name' => 'anchorLink',
                    'type' => 'message',
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
            ],
        ]
    ];
}

add_filter('acf/load_field/name=anchorLink', function ($field) {
    // Use a local copy; never overwrite the global WP_Post in admin.
    $wpPost = get_post();
    if (!$wpPost) {
        return $field;
    }

    $href = getPreviewPermalink($wpPost);
    if (!$href) {
        return $field;
    }

    $context = Timber::context();
    $context['post'] = Timber::get_post($wpPost);
    $context['href'] = $href;

    $templateDir = get_template_directory();
    $componentPath = $templateDir . '/Components/BlockAnchor';

    $content = [
        'copiedMessage' => __('Link copied ', 'flynt'),
        'description' => __('Copy the link and use it anywhere on the page to scroll to this position.', 'flynt'),
        'buttonText' =>  __('Copy link', 'flynt')
    ];
    $content = array_merge($content, $context);
    $message = Timber::compile(
        $componentPath . '/Partials/_anchorLink.twig',
        $content
    );
    // Labels are escaped by ACF, so the URL markup lives in the message.
    $field['message'] = $message;
    return $field;
});

/**
 * Permalink as it will be once published.
 * Drafts/auto-drafts otherwise return "?p=123" or "?page_id=123".
 */
function getPreviewPermalink(\WP_Post $wpPost)
{
    if (in_array($wpPost->post_status, ['publish', 'private'], true)) {
        return get_permalink($wpPost);
    }

    if (!function_exists('get_sample_permalink')) {
        require_once ABSPATH . 'wp-admin/includes/post.php';
    }

    [$permalink, $postName] = get_sample_permalink($wpPost->ID);
    if (!$postName) {
        return get_permalink($wpPost);
    }

    return str_replace(['%pagename%', '%postname%'], $postName, $permalink);
}
