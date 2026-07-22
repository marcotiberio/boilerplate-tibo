<?php

namespace Flynt\Components\BlockFormChimpanzeeSponsor;

use Timber\Timber;

/**
 * Pull the selected chimpanzee's photo, details and FundraisingBox form data
 * off its post (see inc/fieldGroups/chimpanzeeComponents.php) so the block only
 * needs a post picker — no duplicated form fields.
 */
add_filter('Flynt/addComponentData?name=BlockFormChimpanzeeSponsor', function ($data) {
    $selected = $data['chimpanzee'] ?? null;
    $data['chimp'] = null;

    if ($selected) {
        $id = is_object($selected) ? $selected->ID : (int) $selected;
        $post = Timber::get_post($id);

        if ($post) {
            $thumbnail = get_the_post_thumbnail_url($id, 'large');
            $data['chimp'] = [
                'id' => $id,
                'title' => $post->title,
                'image' => [
                    'src' => $thumbnail ?: '',
                    'alt' => $post->title,
                ],
                'sex' => get_field('sex', $id),
                'sanctuary' => get_field('sanctuary', $id),
                'born' => get_field('born', $id),
                'arrival' => get_field('arrival', $id),
                'description' => get_field('description', $id),
                'formHash' => get_field('formHash', $id),
                'fbItemId' => get_field('fbItemId', $id),
                'formEmbedCode' => get_field('formEmbedCode', $id),
            ];
        }
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'BlockFormChimpanzeeSponsor',
        'label' => __('Block: Form Chimpanzee Sponsorship (FundraisingBox)', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Chimpanzee', 'flynt'),
                'instructions' => __('Select the chimpanzee to sponsor. The photo, details and FundraisingBox form are pulled from the chimpanzee post.', 'flynt'),
                'name' => 'chimpanzee',
                'type' => 'post_object',
                'post_type' => ['chimpanzee'],
                'return_format' => 'id',
                'ui' => 1,
                'required' => 1,
            ],
            [
                'label' => __('Title override', 'flynt'),
                'instructions' => __('Optional. Defaults to “{Name}’s Patenschaft”.', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'required' => 0,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Title Size', 'flynt'),
                'instructions' => __('Visual size of the headline.', 'flynt'),
                'name' => 'titleSize',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Title Tag', 'flynt'),
                'instructions' => __('HTML tag used for the headline (accessibility / SEO).', 'flynt'),
                'name' => 'titleTag',
                'type' => 'select',
                'choices' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'default_value' => 'h2',
                'allow_null' => 0,
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Fallback height (px)', 'flynt'),
                'instructions' => __('Reserved min-height for the form area to avoid layout shift while it loads. Default 900.', 'flynt'),
                'name' => 'formHeight',
                'type' => 'number',
                'default_value' => 900,
                'min' => 0,
                'required' => 0,
            ],
            [
                'label' => __('Theme', 'flynt'),
                'name' => 'theme',
                'type' => 'select',
                'default_value' => 'offWhite',
                'choices' => [
                    'offWhite' => __('Off White', 'flynt'),
                    'beige' => __('Beige', 'flynt'),
                ],
            ],
        ],
    ];
}
