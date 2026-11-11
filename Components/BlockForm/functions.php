<?php

namespace Flynt\Components\BlockForm;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=BlockForm', function ($data) {
    $data['formHtml'] = '';
    $source = $data['source'] ?? 'rsvp';

    if ($source === 'rsvp') {
        $data['formHtml'] = getRsvpForm((int) ($data['event'] ?? 0));
    } elseif ($source === 'shortcode' && !empty($data['shortcode'])) {
        $data['formHtml'] = do_shortcode(wp_strip_all_tags($data['shortcode']));
    }

    return $data;
});

/**
 * Event Tickets RSVP form of one event, rendered through the plugin's own
 * tribe/rsvp block so it follows whichever RSVP implementation is active.
 */
function getRsvpForm($eventId)
{
    if (!$eventId || !function_exists('tribe_tickets') || get_post_status($eventId) !== 'publish') {
        return '';
    }

    global $post;
    $originalPost = $post;
    $post = get_post($eventId);
    setup_postdata($post);

    $html = do_blocks('<!-- wp:tribe/rsvp /-->');

    $post = $originalPost;
    wp_reset_postdata();

    return trim(wp_strip_all_tags($html)) === '' ? '' : $html;
}

function getACFLayout()
{
    return [
        'name' => 'BlockForm',
        'label' => __('Block: Form', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Description', 'flynt'),
                'name' => 'description',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Form Source', 'flynt'),
                'name' => 'source',
                'type' => 'button_group',
                'choices' => [
                    'rsvp' => __('Event registration (RSVP)', 'flynt'),
                    'shortcode' => __('Form shortcode', 'flynt'),
                ],
                'default_value' => 'rsvp',
            ],
            [
                'label' => __('Event', 'flynt'),
                'instructions' => __('The event must have an RSVP ticket (Event Tickets).', 'flynt'),
                'name' => 'event',
                'type' => 'post_object',
                'post_type' => ['tribe_events'],
                'return_format' => 'id',
                'ui' => 1,
                'allow_null' => 1,
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'rsvp',
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Shortcode', 'flynt'),
                'instructions' => __('e.g. a Contact Form 7 shortcode.', 'flynt'),
                'name' => 'shortcode',
                'type' => 'text',
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'source',
                            'operator' => '==',
                            'value' => 'shortcode',
                        ],
                    ],
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getSectionTheme('sage'),
                    FieldVariables\getDecoration(),
                ],
            ],
        ],
    ];
}
