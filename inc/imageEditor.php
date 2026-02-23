<?php

/**
 * P5.js Alpha Mask Editor – Apply alpha masks to featured images with
 * tweakable presets (radial, linear, diagonal, corner fade, etc.).
 * Masks can be baked into a PNG or rendered live on the frontend via p5.js.
 */

namespace Flynt\ImageEditor;

use Flynt\Utils\Asset;

// ---------- Meta box ----------

add_action('add_meta_boxes', function () {
    $post_types = get_post_types(['public' => true]);

    foreach ($post_types as $post_type) {
        add_meta_box(
            'p5_alpha_mask_editor',
            __('Alpha Mask Editor', 'flynt'),
            __NAMESPACE__ . '\\renderMetaBox',
            $post_type,
            'side',
            'default'
        );
    }
});

function renderMetaBox($post)
{
    $thumbnail_id  = get_post_thumbnail_id($post->ID);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    $saved_mask    = get_post_meta($post->ID, '_p5_alpha_mask', true);
    wp_nonce_field('p5_alpha_mask_nonce', 'p5_alpha_mask_nonce');
    ?>
    <div id="p5-mask-editor-wrap"
         data-post-id="<?php echo esc_attr($post->ID); ?>"
         data-thumb-url="<?php echo esc_url($thumbnail_url); ?>"
         data-saved-mask="<?php echo esc_attr($saved_mask ? wp_json_encode($saved_mask) : ''); ?>">

        <!-- Source area: shown when editor is closed -->
        <div id="p5-mask-source">
            <?php if ($thumbnail_url) : ?>
                <p class="p5-current-thumb">
                    <strong><?php esc_html_e('Featured image:', 'flynt'); ?></strong><br>
                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt=""
                         style="max-width:100%;height:auto;">
                </p>
                <div class="p5-mask-actions-start">
                    <button type="button" class="button" id="p5-open-mask-editor">
                        <?php esc_html_e('Open Mask Editor', 'flynt'); ?>
                    </button>
                </div>
            <?php else : ?>
                <p class="p5-no-thumb">
                    <?php esc_html_e('Set a featured image first, then open the mask editor.', 'flynt'); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Editor area: hidden until opened -->
        <div id="p5-mask-editor" style="display:none;">

            <!-- Preset selector -->
            <div id="p5-mask-presets">
                <label class="p5-label"><?php esc_html_e('Mask Preset', 'flynt'); ?></label>
                <div class="p5-preset-buttons">
                    <button type="button" class="p5-preset-btn active" data-preset="radial"
                            title="<?php esc_attr_e('Radial', 'flynt'); ?>">
                        <span class="dashicons dashicons-marker"></span>
                        <span class="p5-preset-label"><?php esc_html_e('Radial', 'flynt'); ?></span>
                    </button>
                    <button type="button" class="p5-preset-btn" data-preset="linear"
                            title="<?php esc_attr_e('Linear', 'flynt'); ?>">
                        <span class="dashicons dashicons-image-rotate-right"></span>
                        <span class="p5-preset-label"><?php esc_html_e('Linear', 'flynt'); ?></span>
                    </button>
                    <button type="button" class="p5-preset-btn" data-preset="diagonal"
                            title="<?php esc_attr_e('Diagonal', 'flynt'); ?>">
                        <span class="dashicons dashicons-arrow-right-alt"></span>
                        <span class="p5-preset-label"><?php esc_html_e('Diagonal', 'flynt'); ?></span>
                    </button>
                    <button type="button" class="p5-preset-btn" data-preset="corner"
                            title="<?php esc_attr_e('Corner', 'flynt'); ?>">
                        <span class="dashicons dashicons-screenoptions"></span>
                        <span class="p5-preset-label"><?php esc_html_e('Corner', 'flynt'); ?></span>
                    </button>
                    <button type="button" class="p5-preset-btn" data-preset="split"
                            title="<?php esc_attr_e('Split', 'flynt'); ?>">
                        <span class="dashicons dashicons-columns"></span>
                        <span class="p5-preset-label"><?php esc_html_e('Split', 'flynt'); ?></span>
                    </button>
                </div>
            </div>

            <!-- Shared parameters -->
            <div id="p5-mask-params">
                <!-- Radial params -->
                <div class="p5-param-group" data-for="radial">
                    <label class="p5-label"><?php esc_html_e('Center X', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="centerX"
                               min="0" max="100" value="50">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Center Y', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="centerY"
                               min="0" max="100" value="50">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Radius', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="radius"
                               min="5" max="100" value="50">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Softness', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="softness"
                               min="0" max="100" value="40">
                    </label>
                </div>

                <!-- Linear params -->
                <div class="p5-param-group" data-for="linear" style="display:none;">
                    <label class="p5-label"><?php esc_html_e('Angle', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="angle"
                               min="0" max="360" value="180">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Position', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="position"
                               min="0" max="100" value="50">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Spread', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="spread"
                               min="1" max="100" value="50">
                    </label>
                </div>

                <!-- Diagonal params -->
                <div class="p5-param-group" data-for="diagonal" style="display:none;">
                    <label class="p5-label"><?php esc_html_e('Direction', 'flynt'); ?>
                        <select class="p5-param" data-param="direction">
                            <option value="tl-br"><?php esc_html_e('Top-Left → Bottom-Right', 'flynt'); ?></option>
                            <option value="tr-bl"><?php esc_html_e('Top-Right → Bottom-Left', 'flynt'); ?></option>
                            <option value="bl-tr"><?php esc_html_e('Bottom-Left → Top-Right', 'flynt'); ?></option>
                            <option value="br-tl"><?php esc_html_e('Bottom-Right → Top-Left', 'flynt'); ?></option>
                        </select>
                    </label>
                    <label class="p5-label"><?php esc_html_e('Spread', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="spread"
                               min="1" max="100" value="50">
                    </label>
                </div>

                <!-- Corner params -->
                <div class="p5-param-group" data-for="corner" style="display:none;">
                    <label class="p5-label"><?php esc_html_e('Corner', 'flynt'); ?>
                        <select class="p5-param" data-param="corner">
                            <option value="tl"><?php esc_html_e('Top-Left', 'flynt'); ?></option>
                            <option value="tr"><?php esc_html_e('Top-Right', 'flynt'); ?></option>
                            <option value="bl"><?php esc_html_e('Bottom-Left', 'flynt'); ?></option>
                            <option value="br"><?php esc_html_e('Bottom-Right', 'flynt'); ?></option>
                        </select>
                    </label>
                    <label class="p5-label"><?php esc_html_e('Radius', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="radius"
                               min="5" max="100" value="50">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Softness', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="softness"
                               min="0" max="100" value="40">
                    </label>
                </div>

                <!-- Split params -->
                <div class="p5-param-group" data-for="split" style="display:none;">
                    <label class="p5-label"><?php esc_html_e('Orientation', 'flynt'); ?>
                        <select class="p5-param" data-param="orientation">
                            <option value="horizontal"><?php esc_html_e('Horizontal', 'flynt'); ?></option>
                            <option value="vertical"><?php esc_html_e('Vertical', 'flynt'); ?></option>
                        </select>
                    </label>
                    <label class="p5-label"><?php esc_html_e('Position', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="position"
                               min="0" max="100" value="50">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Spread', 'flynt'); ?>
                        <input type="range" class="p5-param" data-param="spread"
                               min="1" max="100" value="30">
                    </label>
                    <label class="p5-label"><?php esc_html_e('Side', 'flynt'); ?>
                        <select class="p5-param" data-param="side">
                            <option value="first"><?php esc_html_e('Fade first half', 'flynt'); ?></option>
                            <option value="second"><?php esc_html_e('Fade second half', 'flynt'); ?></option>
                        </select>
                    </label>
                </div>

                <!-- Global option: invert -->
                <label class="p5-label p5-label-inline">
                    <input type="checkbox" class="p5-param" data-param="invert" id="p5-mask-invert">
                    <?php esc_html_e('Invert mask', 'flynt'); ?>
                </label>
            </div>

            <!-- Canvas -->
            <div id="p5-mask-canvas-container"></div>

            <!-- Actions -->
            <div id="p5-mask-actions">
                <button type="button" class="button button-primary" id="p5-mask-save-bake">
                    <?php esc_html_e('Bake & Set as Featured', 'flynt'); ?>
                </button>
                <button type="button" class="button" id="p5-mask-save-live">
                    <?php esc_html_e('Save for Frontend', 'flynt'); ?>
                </button>
                <button type="button" class="button" id="p5-mask-remove">
                    <?php esc_html_e('Remove Mask', 'flynt'); ?>
                </button>
                <button type="button" class="button" id="p5-mask-close">
                    <?php esc_html_e('Close', 'flynt'); ?>
                </button>
                <span id="p5-mask-status"></span>
            </div>
        </div>
    </div>
    <?php
}

// ---------- Enqueue ----------

add_action('admin_enqueue_scripts', function ($hook) {
    if (!in_array($hook, ['post.php', 'post-new.php'], true)) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'p5js',
        'https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.min.js',
        [],
        '1.9.0',
        true
    );

    wp_enqueue_script(
        'p5-image-editor',
        get_template_directory_uri() . '/assets/p5-image-editor.js',
        ['p5js', 'jquery'],
        filemtime(get_template_directory() . '/assets/p5-image-editor.js'),
        true
    );

    wp_enqueue_style(
        'p5-image-editor',
        get_template_directory_uri() . '/assets/p5-image-editor.css',
        [],
        filemtime(get_template_directory() . '/assets/p5-image-editor.css')
    );

    wp_localize_script('p5-image-editor', 'p5MaskData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('p5_alpha_mask_nonce'),
        'postId'  => get_the_ID(),
    ]);
});

// ---------- AJAX: bake masked image as featured ----------

add_action('wp_ajax_p5_bake_masked_image', function () {
    check_ajax_referer('p5_alpha_mask_nonce', 'nonce');

    if (!current_user_can('upload_files')) {
        wp_send_json_error(['message' => __('You do not have permission to upload files.', 'flynt')]);
    }

    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    if (!$post_id || !current_user_can('edit_post', $post_id)) {
        wp_send_json_error(['message' => __('Invalid post.', 'flynt')]);
    }

    $image_data = isset($_POST['image_data']) ? $_POST['image_data'] : '';
    if (empty($image_data)) {
        wp_send_json_error(['message' => __('No image data received.', 'flynt')]);
    }

    if (preg_match('/^data:image\/(png|jpe?g|webp);base64,/', $image_data, $matches)) {
        $ext        = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $image_data = preg_replace('/^data:image\/\w+;base64,/', '', $image_data);
        $image_data = base64_decode($image_data);

        if ($image_data === false) {
            wp_send_json_error(['message' => __('Failed to decode image data.', 'flynt')]);
        }
    } else {
        wp_send_json_error(['message' => __('Invalid image data format.', 'flynt')]);
    }

    $upload_dir = wp_upload_dir();
    $filename   = 'masked-' . $post_id . '-' . time() . '.' . $ext;
    $file_path  = $upload_dir['path'] . '/' . $filename;

    if (file_put_contents($file_path, $image_data) === false) {
        wp_send_json_error(['message' => __('Failed to save image file.', 'flynt')]);
    }

    $file_url  = $upload_dir['url'] . '/' . $filename;
    $mime_type = wp_check_filetype($filename)['type'];

    $attachment = [
        'post_mime_type' => $mime_type,
        'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $file_path, $post_id);

    if (is_wp_error($attach_id)) {
        wp_send_json_error(['message' => $attach_id->get_error_message()]);
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
    wp_update_attachment_metadata($attach_id, $attach_data);

    set_post_thumbnail($post_id, $attach_id);

    // Clear any saved live-mask params when baking
    delete_post_meta($post_id, '_p5_alpha_mask');

    wp_send_json_success([
        'message'      => __('Masked image saved and set as featured image.', 'flynt'),
        'attachmentId' => $attach_id,
        'imageUrl'     => $file_url,
    ]);
});

// ---------- AJAX: save mask params for frontend rendering ----------

add_action('wp_ajax_p5_save_mask_params', function () {
    check_ajax_referer('p5_alpha_mask_nonce', 'nonce');

    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    if (!$post_id || !current_user_can('edit_post', $post_id)) {
        wp_send_json_error(['message' => __('Invalid post.', 'flynt')]);
    }

    $params = isset($_POST['mask_params']) ? $_POST['mask_params'] : '';
    if (empty($params)) {
        wp_send_json_error(['message' => __('No mask parameters received.', 'flynt')]);
    }

    $decoded = json_decode(wp_unslash($params), true);
    if (!is_array($decoded) || empty($decoded['preset'])) {
        wp_send_json_error(['message' => __('Invalid mask parameters.', 'flynt')]);
    }

    // Sanitize all values
    $sanitized = [];
    foreach ($decoded as $key => $value) {
        $sanitized[sanitize_key($key)] = is_numeric($value) ? floatval($value) : sanitize_text_field($value);
    }

    update_post_meta($post_id, '_p5_alpha_mask', $sanitized);

    wp_send_json_success([
        'message' => __('Mask parameters saved for frontend rendering.', 'flynt'),
    ]);
});

// ---------- AJAX: remove mask ----------

add_action('wp_ajax_p5_remove_mask', function () {
    check_ajax_referer('p5_alpha_mask_nonce', 'nonce');

    $post_id = isset($_POST['post_id']) ? absint($_POST['post_id']) : 0;
    if (!$post_id || !current_user_can('edit_post', $post_id)) {
        wp_send_json_error(['message' => __('Invalid post.', 'flynt')]);
    }

    delete_post_meta($post_id, '_p5_alpha_mask');

    wp_send_json_success([
        'message' => __('Mask removed.', 'flynt'),
    ]);
});

// ---------- Frontend: enqueue p5.js mask renderer ----------

add_action('wp_enqueue_scripts', function () {
    if (!is_singular()) {
        return;
    }

    $post_id = get_the_ID();
    $mask    = get_post_meta($post_id, '_p5_alpha_mask', true);

    if (empty($mask) || !is_array($mask)) {
        return;
    }

    $thumbnail_id  = get_post_thumbnail_id($post_id);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';

    if (!$thumbnail_url) {
        return;
    }

    wp_enqueue_script(
        'p5js',
        'https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.min.js',
        [],
        '1.9.0',
        true
    );

    wp_enqueue_script(
        'p5-mask-frontend',
        get_template_directory_uri() . '/assets/p5-mask-frontend.js',
        ['p5js'],
        filemtime(get_template_directory() . '/assets/p5-mask-frontend.js'),
        true
    );

    wp_localize_script('p5-mask-frontend', 'p5MaskFrontend', [
        'imageUrl'   => $thumbnail_url,
        'maskParams' => $mask,
    ]);
});
