<?php

namespace App\Blocks;

/**
 * Register all ACF Gutenberg blocks.
 *
 * Each block uses acf_register_block_type() with a Blade template
 * in resources/views/blocks/. ACF fields are registered separately
 * via field group files in app/Blocks/Fields/.
 */
function register_all_blocks(): void
{
    $blocks = [
        [
            'name' => 'hero-image',
            'title' => __('Hero Image', 'sage'),
            'description' => 'Full-screen hero with responsive desktop/mobile images.',
            'category' => 'theme-blocks',
            'icon' => 'cover-image',
            'keywords' => ['hero', 'banner', 'image'],
            'mode' => 'preview',
        ],
        [
            'name' => 'image-text',
            'title' => __('Image + Text', 'sage'),
            'description' => 'Two-column layout with image and text content.',
            'category' => 'theme-blocks',
            'icon' => 'align-pull-left',
            'keywords' => ['image', 'text', 'columns'],
            'mode' => 'preview',
        ],
        [
            'name' => 'wysiwyg',
            'title' => __('Text Editor', 'sage'),
            'description' => 'Rich text editor with flexible positioning.',
            'category' => 'theme-blocks',
            'icon' => 'editor-paragraph',
            'keywords' => ['text', 'wysiwyg', 'content'],
            'mode' => 'preview',
        ],
        [
            'name' => 'banner-cta',
            'title' => __('Banner CTA', 'sage'),
            'description' => 'Call-to-action banner with background image.',
            'category' => 'theme-blocks',
            'icon' => 'megaphone',
            'keywords' => ['banner', 'cta', 'call to action'],
            'mode' => 'preview',
        ],
        [
            'name' => 'gallery-media',
            'title' => __('Gallery Media', 'sage'),
            'description' => 'Grid gallery with mixed media (images, videos, embeds).',
            'category' => 'theme-blocks',
            'icon' => 'format-gallery',
            'keywords' => ['gallery', 'media', 'grid'],
            'mode' => 'preview',
        ],
        [
            'name' => 'grid-images',
            'title' => __('Grid Images', 'sage'),
            'description' => 'Image grid with configurable columns and lightbox.',
            'category' => 'theme-blocks',
            'icon' => 'grid-view',
            'keywords' => ['grid', 'images', 'gallery'],
            'mode' => 'preview',
        ],
        [
            'name' => 'grid-image-text',
            'title' => __('Grid Image Text', 'sage'),
            'description' => 'Grid of cards with image, title, and text.',
            'category' => 'theme-blocks',
            'icon' => 'screenoptions',
            'keywords' => ['grid', 'cards', 'image', 'text'],
            'mode' => 'preview',
        ],
        [
            'name' => 'slider-logos',
            'title' => __('Carousel Logos', 'sage'),
            'description' => 'Horizontal marquee carousel of logos.',
            'category' => 'theme-blocks',
            'icon' => 'slides',
            'keywords' => ['slider', 'logos', 'carousel', 'marquee'],
            'mode' => 'preview',
        ],
        [
            'name' => 'slider-box',
            'title' => __('Carousel Boxes', 'sage'),
            'description' => 'Swiper carousel of text boxes.',
            'category' => 'theme-blocks',
            'icon' => 'slides',
            'keywords' => ['slider', 'carousel', 'boxes'],
            'mode' => 'preview',
        ],
        [
            'name' => 'video-oembed',
            'title' => __('Video Embed', 'sage'),
            'description' => 'Embedded video player (YouTube, Vimeo).',
            'category' => 'theme-blocks',
            'icon' => 'video-alt3',
            'keywords' => ['video', 'embed', 'youtube', 'vimeo'],
            'mode' => 'preview',
        ],
        [
            'name' => 'spacer',
            'title' => __('Spacer', 'sage'),
            'description' => 'Vertical spacing between sections.',
            'category' => 'theme-blocks',
            'icon' => 'arrows-alt-v',
            'keywords' => ['spacer', 'spacing', 'gap'],
            'mode' => 'preview',
        ],
        [
            'name' => 'divider',
            'title' => __('Divider', 'sage'),
            'description' => 'Horizontal divider line.',
            'category' => 'theme-blocks',
            'icon' => 'minus',
            'keywords' => ['divider', 'separator', 'line'],
            'mode' => 'preview',
        ],
    ];

    foreach ($blocks as $block) {
        acf_register_block_type(array_merge($block, [
            'render_callback' => __NAMESPACE__ . '\\render_block',
            'enqueue_style' => get_theme_file_uri("public/styles/blocks/{$block['name']}.css"),
            'supports' => [
                'align' => false,
                'anchor' => true,
                'jsx' => false,
            ],
        ]));
    }
}

/**
 * Render callback for ACF blocks.
 * Loads the corresponding Blade template from resources/views/blocks/.
 */
function render_block(array $block, string $content = '', bool $is_preview = false, int $post_id = 0): void
{
    $slug = str_replace('acf/', '', $block['name']);
    $view_path = "blocks.{$slug}";

    // Make block data available to the Blade template
    $data = [
        'block' => $block,
        'is_preview' => $is_preview,
        'post_id' => $post_id,
    ];

    // If using Acorn's view system
    if (function_exists('\Roots\view')) {
        echo \Roots\view($view_path, $data)->render();
        return;
    }

    // Fallback: load Blade template directly
    $template = get_theme_file_path("resources/views/blocks/{$slug}.blade.php");
    if (file_exists($template)) {
        // Extract ACF fields for the template
        $fields = get_fields();
        if ($fields) {
            extract($fields);
        }
        extract($data);
        include $template;
    }
}
