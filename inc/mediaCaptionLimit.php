<?php

/**
 * Character limit for the built-in WordPress caption of media files
 * (the attachment `post_excerpt`, labelled "Image Caption" in the backend).
 *
 * The caption is edited in several core screens that can't be filtered
 * (the Backbone media modal templates and the Edit Media form), so the limit
 * is applied as a `maxlength` attribute by assets/admin.js — the value is
 * shared with it through `FlyntMediaCaption`. It is enforced again on save to
 * cover REST, imports and programmatic updates, where no input exists.
 */

namespace Flynt\MediaCaptionLimit;

const MAX_LENGTH = 40;

add_action('admin_enqueue_scripts', function () {
    wp_localize_script('Flynt/assets/admin', 'FlyntMediaCaption', [
        'maxLength' => MAX_LENGTH,
    ]);
}, 20);

add_filter('wp_insert_attachment_data', function ($data) {
    if (empty($data['post_excerpt'])) {
        return $data;
    }

    $caption = wp_unslash($data['post_excerpt']);

    if (mb_strlen($caption) > MAX_LENGTH) {
        $data['post_excerpt'] = wp_slash(mb_substr($caption, 0, MAX_LENGTH));
    }

    return $data;
});
