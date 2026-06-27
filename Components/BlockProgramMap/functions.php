<?php

namespace Flynt\Components\BlockProgramMap;

use Flynt\ProgramEntry;

function getACFLayout()
{
    return [
        'name' => 'blockProgramMap',
        'label' => __('Map Program', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Intro', 'flynt'),
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
                'required' => 0,
            ],
            [
                'label' => __('Default centre (lat, lng)', 'flynt'),
                'instructions' => __('Map centre when no entries are visible, e.g. "52.3676, 4.9041" for Amsterdam.', 'flynt'),
                'name' => 'center',
                'type' => 'text',
                'default_value' => '52.3676, 4.9041',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Default zoom', 'flynt'),
                'name' => 'zoom',
                'type' => 'number',
                'default_value' => 12,
                'min' => 1,
                'max' => 18,
                'wrapper' => ['width' => 50],
            ],
        ],
    ];
}

// Query published entries that have a pin and hand them to the template as
// a plain array; the Leaflet script reads it from an inline JSON block.
add_filter('Flynt/addComponentData?name=BlockProgramMap', function ($data) {
    $config = ProgramEntry\getConfig();

    $posts = get_posts([
        'post_type'      => ProgramEntry\POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => [
            ['key' => 'location', 'compare' => 'EXISTS'],
        ],
    ]);

    $data['entries'] = array_values(array_filter(array_map(function ($post) use ($config) {
        $location = get_field('location', $post->ID);
        if (empty($location['lat']) || empty($location['lng'])) {
            return null;
        }
        $formatKey = get_field('format', $post->ID);
        return [
            'title'       => get_the_title($post),
            'description' => wp_trim_words(get_field('description', $post->ID) ?: '', 30),
            'category'    => $config['format'][$formatKey] ?? '',
            'link'        => get_permalink($post),
            'lat'         => (float) $location['lat'],
            'lng'         => (float) $location['lng'],
        ];
    }, $posts)));

    return $data;
});
