<?php

/**
 * P5.js Image Editor - Meta box for editing images before setting as featured image.
 */

namespace Flynt\ImageEditor;

use Flynt\Utils\Asset;

/**
 * Register the image editor meta box on post edit screens.
 */
add_action('add_meta_boxes', function () {
    $post_types = get_post_types(['public' => true]);

    foreach ($post_types as $post_type) {
        add_meta_box(
            'p5_image_editor',
            __('Image Editor', 'flynt'),
            __NAMESPACE__ . '\\renderMetaBox',
            $post_type,
            'side',
            'default'
        );
    }
});

/**
 * Render the meta box HTML.
 */
function renderMetaBox($post)
{
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $thumbnail_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
    wp_nonce_field('p5_image_editor_nonce', 'p5_image_editor_nonce');
    ?>
    <div id="p5-image-editor-wrap" data-post-id="<?php echo esc_attr($post->ID); ?>">
        <div id="p5-editor-source">
            <?php if ($thumbnail_url) : ?>
                <p class="p5-current-thumb">
                    <strong><?php esc_html_e('Current featured image:', 'flynt'); ?></strong><br>
                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="" style="max-width:100%;height:auto;">
                </p>
            <?php endif; ?>

            <div class="p5-editor-upload-area">
                <button type="button" class="button p5-select-image" id="p5-select-image">
                    <?php esc_html_e('Select / Upload Image to Edit', 'flynt'); ?>
                </button>
            </div>
        </div>

        <div id="p5-editor-canvas-wrap" style="display:none;">
            <div id="p5-editor-toolbar">
                <div class="p5-toolbar-group">
                    <button type="button" class="button p5-tool-btn" data-tool="crop" title="Crop">
                        <span class="dashicons dashicons-image-crop"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="rotate" title="Rotate 90°">
                        <span class="dashicons dashicons-image-rotate"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="flip-h" title="Flip Horizontal">
                        <span class="dashicons dashicons-image-flip-horizontal"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="flip-v" title="Flip Vertical">
                        <span class="dashicons dashicons-image-flip-vertical"></span>
                    </button>
                </div>
                <div class="p5-toolbar-group">
                    <button type="button" class="button p5-tool-btn" data-tool="draw" title="Draw">
                        <span class="dashicons dashicons-art"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="text" title="Add Text">
                        <span class="dashicons dashicons-editor-textcolor"></span>
                    </button>
                </div>
                <div class="p5-toolbar-group">
                    <button type="button" class="button p5-tool-btn" data-tool="brightness" title="Brightness">
                        <span class="dashicons dashicons-visibility"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="grayscale" title="Grayscale">
                        <span class="dashicons dashicons-admin-appearance"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="blur" title="Blur">
                        <span class="dashicons dashicons-cloud"></span>
                    </button>
                </div>
                <div class="p5-toolbar-group">
                    <button type="button" class="button p5-tool-btn" data-tool="undo" title="Undo">
                        <span class="dashicons dashicons-undo"></span>
                    </button>
                    <button type="button" class="button p5-tool-btn" data-tool="reset" title="Reset">
                        <span class="dashicons dashicons-image-rotate-left"></span>
                    </button>
                </div>
            </div>

            <div id="p5-tool-options" style="display:none;">
                <!-- Draw options -->
                <div class="p5-options-panel" data-for="draw" style="display:none;">
                    <label>
                        <?php esc_html_e('Color:', 'flynt'); ?>
                        <input type="color" id="p5-draw-color" value="#ff0000">
                    </label>
                    <label>
                        <?php esc_html_e('Size:', 'flynt'); ?>
                        <input type="range" id="p5-draw-size" min="1" max="50" value="5">
                    </label>
                </div>
                <!-- Text options -->
                <div class="p5-options-panel" data-for="text" style="display:none;">
                    <label>
                        <?php esc_html_e('Text:', 'flynt'); ?>
                        <input type="text" id="p5-text-input" placeholder="<?php esc_attr_e('Enter text...', 'flynt'); ?>">
                    </label>
                    <label>
                        <?php esc_html_e('Color:', 'flynt'); ?>
                        <input type="color" id="p5-text-color" value="#ffffff">
                    </label>
                    <label>
                        <?php esc_html_e('Size:', 'flynt'); ?>
                        <input type="range" id="p5-text-size" min="12" max="120" value="32">
                    </label>
                </div>
                <!-- Brightness options -->
                <div class="p5-options-panel" data-for="brightness" style="display:none;">
                    <label>
                        <?php esc_html_e('Brightness:', 'flynt'); ?>
                        <input type="range" id="p5-brightness-value" min="-100" max="100" value="0">
                    </label>
                    <button type="button" class="button button-small" id="p5-apply-brightness">
                        <?php esc_html_e('Apply', 'flynt'); ?>
                    </button>
                </div>
                <!-- Crop confirm -->
                <div class="p5-options-panel" data-for="crop" style="display:none;">
                    <p class="description"><?php esc_html_e('Click and drag on the image to select crop area.', 'flynt'); ?></p>
                    <button type="button" class="button button-small" id="p5-apply-crop">
                        <?php esc_html_e('Apply Crop', 'flynt'); ?>
                    </button>
                    <button type="button" class="button button-small" id="p5-cancel-crop">
                        <?php esc_html_e('Cancel', 'flynt'); ?>
                    </button>
                </div>
            </div>

            <div id="p5-canvas-container"></div>

            <div id="p5-editor-actions">
                <button type="button" class="button button-primary" id="p5-save-featured">
                    <?php esc_html_e('Set as Featured Image', 'flynt'); ?>
                </button>
                <button type="button" class="button" id="p5-close-editor">
                    <?php esc_html_e('Close Editor', 'flynt'); ?>
                </button>
                <span id="p5-save-status"></span>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Enqueue p5.js and the editor script/styles on post edit screens.
 */
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
        ['p5js', 'jquery', 'wp-util'],
        filemtime(get_template_directory() . '/assets/p5-image-editor.js'),
        true
    );

    wp_enqueue_style(
        'p5-image-editor',
        get_template_directory_uri() . '/assets/p5-image-editor.css',
        [],
        filemtime(get_template_directory() . '/assets/p5-image-editor.css')
    );

    wp_localize_script('p5-image-editor', 'p5EditorData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('p5_image_editor_nonce'),
        'postId' => get_the_ID(),
    ]);
});

/**
 * AJAX handler: save the edited image and set it as the featured image.
 */
add_action('wp_ajax_p5_save_edited_image', function () {
    check_ajax_referer('p5_image_editor_nonce', 'nonce');

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

    // Parse base64 data URL.
    if (preg_match('/^data:image\/(png|jpe?g|webp);base64,/', $image_data, $matches)) {
        $ext = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $image_data = preg_replace('/^data:image\/\w+;base64,/', '', $image_data);
        $image_data = base64_decode($image_data);

        if ($image_data === false) {
            wp_send_json_error(['message' => __('Failed to decode image data.', 'flynt')]);
        }
    } else {
        wp_send_json_error(['message' => __('Invalid image data format.', 'flynt')]);
    }

    $upload_dir = wp_upload_dir();
    $filename = 'edited-image-' . $post_id . '-' . time() . '.' . $ext;
    $file_path = $upload_dir['path'] . '/' . $filename;

    // Write image file.
    if (file_put_contents($file_path, $image_data) === false) {
        wp_send_json_error(['message' => __('Failed to save image file.', 'flynt')]);
    }

    $file_url = $upload_dir['url'] . '/' . $filename;
    $mime_type = wp_check_filetype($filename)['type'];

    // Create attachment.
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

    // Set as featured image.
    set_post_thumbnail($post_id, $attach_id);

    wp_send_json_success([
        'message'      => __('Image saved and set as featured image.', 'flynt'),
        'attachmentId' => $attach_id,
        'imageUrl'     => $file_url,
    ]);
});
