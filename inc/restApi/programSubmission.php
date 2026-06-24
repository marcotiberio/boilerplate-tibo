<?php

/**
 * REST endpoint that receives public submissions from the FormProgramEntry
 * component and stores them as `pending` Program Entry posts for review.
 *
 * Security: nonce check, honeypot, per-IP rate limit, strict sanitisation,
 * choice allow-listing. Anonymous callers can only ever create pending posts.
 */

namespace Flynt\ProgramEntry;

add_action('rest_api_init', function () {
    register_rest_route('looptopia/v1', '/program-entry', [
        'methods' => 'POST',
        'callback' => __NAMESPACE__ . '\\handleSubmission',
        'permission_callback' => '__return_true',
    ]);
});

function handleSubmission(\WP_REST_Request $request)
{
    $params = $request->get_json_params();
    if (empty($params)) {
        $params = $request->get_params();
    }

    // 1. Nonce — rejects cross-site / stale form posts.
    if (empty($params['nonce']) || !wp_verify_nonce($params['nonce'], NONCE_ACTION)) {
        return new \WP_REST_Response([
            'success' => false,
            'message' => __('Your session expired. Please reload the page and try again.', 'flynt'),
        ], 403);
    }

    // 2. Honeypot — a filled hidden field means a bot.
    if (!empty($params['website_hp'])) {
        // Pretend success so bots don't learn the trap exists.
        return new \WP_REST_Response(['success' => true], 200);
    }

    // 3. Rate limit per IP.
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $rateKey = 'le_pe_' . md5($ip);
    $count = (int) get_transient($rateKey);
    if ($count >= 5) {
        return new \WP_REST_Response([
            'success' => false,
            'message' => __('Too many submissions. Please try again later.', 'flynt'),
        ], 429);
    }

    // 4. Sanitise.
    $contactName  = sanitize_text_field($params['contactName'] ?? '');
    $contactEmail = sanitize_email($params['contactEmail'] ?? '');
    $contactPhone = sanitize_text_field($params['contactPhone'] ?? '');
    $description  = sanitize_textarea_field($params['description'] ?? '');
    $address      = sanitize_text_field($params['address'] ?? '');
    $category     = sanitize_key($params['category'] ?? '');
    $themes       = array_map('sanitize_key', (array) ($params['themes'] ?? []));
    $consent      = !empty($params['consent']);

    // 5. Validate.
    $errors = [];
    $config = getConfig();
    if ($contactName === '') {
        $errors[] = __('Please enter your name.', 'flynt');
    }
    if (!is_email($contactEmail)) {
        $errors[] = __('Please enter a valid email address.', 'flynt');
    }
    if ($description === '') {
        $errors[] = __('Please enter a description.', 'flynt');
    }
    if (!isset($config['categories'][$category])) {
        $errors[] = __('Please choose a valid category.', 'flynt');
    }
    $themes = array_values(array_filter($themes, fn ($t) => isset($config['themes'][$t])));
    if (!$consent) {
        $errors[] = __('Please accept the privacy terms.', 'flynt');
    }

    if (!empty($errors)) {
        return new \WP_REST_Response([
            'success' => false,
            'message' => implode(' ', $errors),
        ], 422);
    }

    // 6. Geocode (best-effort — entry is still stored without a pin).
    $geo = geocodeAddress($address);

    // 7. Create the pending post.
    $postId = wp_insert_post([
        'post_type'    => POST_TYPE,
        'post_status'  => 'pending',
        'post_title'   => $contactName,
        'post_content' => $description,
    ], true);

    if (is_wp_error($postId)) {
        return new \WP_REST_Response([
            'success' => false,
            'message' => __('Something went wrong saving your entry. Please try again.', 'flynt'),
        ], 500);
    }

    // 8. Store ACF fields.
    update_field('contactName', $contactName, $postId);
    update_field('contactEmail', $contactEmail, $postId);
    update_field('contactPhone', $contactPhone, $postId);
    update_field('description', $description, $postId);
    update_field('category', $category, $postId);
    update_field('themes', $themes, $postId);
    update_field('address', $geo['formatted'] ?? $address, $postId);
    if ($geo) {
        update_field('location', [
            'address' => $geo['formatted'],
            'lat'     => $geo['lat'],
            'lng'     => $geo['lng'],
        ], $postId);
    }

    // 9. Notify the editor that an entry awaits review.
    $editLink = admin_url('post.php?post=' . $postId . '&action=edit');
    wp_mail(
        get_option('admin_email'),
        __('New program entry awaiting review', 'flynt'),
        sprintf(
            /* translators: 1: contact name, 2: edit link */
            __("A new program entry was submitted by %1\$s.\n\nReview and publish it here:\n%2\$s", 'flynt'),
            $contactName,
            $editLink
        )
    );

    set_transient($rateKey, $count + 1, HOUR_IN_SECONDS);

    return new \WP_REST_Response([
        'success' => true,
        'message' => __('Thanks! Your entry has been submitted for review.', 'flynt'),
    ], 201);
}
