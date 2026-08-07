<?php

namespace Flynt\FieldGroups\Chimpanzee;

use ACFComposer\ACFComposer;
use Flynt\Utils\Options;

// Fallback list used until the sanctuaries are configured in Blocks Settings.
const DEFAULT_SANCTUARIES = [
    'Ngamba Island',
    'Tchimpounga',
    'Chimp Eden',
];

/**
 * Sanctuary names available in the chimpanzee "Auffangstation" dropdown.
 * Editable in Blocks Settings → Default → Chimpanzee.
 *
 * @return string[]
 */
function getSanctuaryNames()
{
    $rows = Options::getTranslatable('Chimpanzee', 'sanctuaries') ?: [];
    $names = array_filter(array_map(function ($row) {
        return trim($row['name'] ?? '');
    }, $rows));

    return empty($names) ? DEFAULT_SANCTUARIES : array_values($names);
}

// Editable sanctuary list.
add_action('acf/init', function () {
    Options::addTranslatable('Chimpanzee', [
        [
            'label' => __('Auffangstationen (sanctuaries)', 'flynt'),
            'instructions' => __('Options for the "Auffangstation" dropdown on chimpanzees. Leave empty to fall back to: Ngamba Island, Tchimpounga, Chimp Eden.', 'flynt'),
            'name' => 'sanctuaries',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => __('Add sanctuary', 'flynt'),
            'sub_fields' => [
                [
                    'label' => __('Name', 'flynt'),
                    'name' => 'name',
                    'type' => 'text',
                ],
            ],
        ],
    ]);
});

// Populate the sanctuary dropdown from the options above.
add_filter('acf/load_field/name=sanctuary', function ($field) {
    // Prevent recursion: reading the options loads their fields, not this one,
    // but guard anyway in case the two groups ever end up on the same screen.
    static $loading = false;
    if ($loading) {
        return $field;
    }
    $loading = true;

    $names = getSanctuaryNames();

    // Keep a value that was saved before it was removed from the list, so
    // editing an existing chimpanzee never silently drops its sanctuary.
    $postId = get_the_ID();
    if ($postId) {
        $current = trim((string) get_post_meta($postId, 'sanctuary', true));
        if ($current !== '' && !in_array($current, $names, true)) {
            $names[] = $current;
        }
    }

    $field['choices'] = array_combine($names, $names);

    $loading = false;

    return $field;
});

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'chimpanzeeMeta',
        'title' => 'Chimpanzee Info',
        'style' => '',
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => __('Sex', 'flynt'),
                'name' => 'sex',
                'type' => 'select',
                'choices' => [
                    'männlich' => __('Männlich', 'flynt'),
                    'weiblich' => __('Weiblich', 'flynt'),
                ],
                'allow_null' => 1,
                'ui' => 1,
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Auffangstation', 'flynt'),
                'name' => 'sanctuary',
                'type' => 'select',
                // Choices are injected by the acf/load_field filter above.
                'choices' => [],
                'allow_null' => 1,
                'ui' => 1,
                'wrapper' => [
                    'width' => 34,
                ],
            ],
            [
                'label' => __('Geboren', 'flynt'),
                'name' => 'born',
                'type' => 'text',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Ankunft', 'flynt'),
                'name' => 'arrival',
                'type' => 'text',
                'wrapper' => [
                    'width' => 33,
                ],
            ],
            [
                'label' => __('Description', 'flynt'),
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 4,
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => __('Sponsorship form (FundraisingBox)', 'flynt'),
                'name' => 'sponsorshipHeadline',
                'type' => 'message',
                'message' => __('The donation form shown on this chimpanzee\'s page. Build/style it on FundraisingBox, then paste its form hash here.', 'flynt'),
            ],
            [
                'label' => __('Form hash (ID)', 'flynt'),
                'instructions' => __('Paste only the form hash from FundraisingBox (Forms → select form → Embed code), e.g. <code>7erkely9zrzg1b9a</code>.', 'flynt'),
                'name' => 'formHash',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Item ID (optional)', 'flynt'),
                'instructions' => __('FundraisingBox <code>fb_item_id</code> — lets one shared form know which chimpanzee is being sponsored.', 'flynt'),
                'name' => 'fbItemId',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Full embed code (advanced)', 'flynt'),
                'instructions' => __('Optional. If FundraisingBox gives you a different snippet, paste it here <strong>exactly</strong>. When set, this overrides the form hash above.', 'flynt'),
                'name' => 'formEmbedCode',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => '',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'chimpanzee',
                ],
            ],
        ],
    ]);
});
