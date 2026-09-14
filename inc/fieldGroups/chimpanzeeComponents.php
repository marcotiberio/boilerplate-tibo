<?php

namespace Flynt\FieldGroups\Chimpanzee;

use ACFComposer\ACFComposer;
use Flynt\Utils\FundraisingBox;
use Flynt\Utils\Options;

// ID of the chimpanzee dropdown in the sponsorship forms, from FundraisingBox →
// Konfiguration → benutzerdef. Felder (column "ID"). The same field is used by
// every sponsorship form, so editors never see or set it.
const CHIMPANZEE_DROPDOWN_FIELD_ID = '16562';

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

/**
 * Compose the FundraisingBox embed URL for a chimpanzee out of the form fields
 * saved on its post, so editors never assemble a query string by hand.
 *
 * Single source of truth for both the backend preview below and the
 * BlockFormChimpanzeeSponsor component.
 *
 * @param int $postId Chimpanzee post ID.
 * @return string Embed URL, or an empty string when no form hash is set.
 */
function getEmbedUrl($postId)
{
    $params = [];

    // Preselect this chimpanzee in the form's dropdown. Like the country
    // below, the selection stays editable: if a value ever stops matching an
    // option, donors can still pick the right one themselves.
    $customField = FundraisingBox::customFieldParam(CHIMPANZEE_DROPDOWN_FIELD_ID);
    if ($customField !== '') {
        $value = trim((string) get_field('fbCustomFieldValue', $postId));
        $params[$customField] = $value !== '' ? $value : get_the_title($postId);
    }

    if (get_field('fbPreselectCountry', $postId)) {
        $params += FundraisingBox::countryParams(get_field('fbCountry', $postId) ?: 'DE');
    }

    return FundraisingBox::embedUrl(get_field('formHash', $postId), $params);
}

/**
 * Ready-to-output embed markup for a chimpanzee: the snippet an editor pasted
 * into "Full embed code" when there is one, otherwise the composed script.
 *
 * @param int $postId Chimpanzee post ID.
 * @return string Embed markup, or an empty string when no form is set up.
 */
function getEmbedScript($postId)
{
    $embedCode = trim((string) get_field('formEmbedCode', $postId));

    if ($embedCode !== '') {
        return $embedCode;
    }

    return FundraisingBox::embedScript(getEmbedUrl($postId));
}

/**
 * Show the composed embed code on the chimpanzee edit screen, so editors can
 * see (and copy) exactly what the fields above produce.
 */
add_filter('acf/prepare_field', function ($field) {
    if (($field['_name'] ?? '') !== 'fbPreview') {
        return $field;
    }

    $postId = get_the_ID();
    $embedUrl = $postId ? getEmbedUrl($postId) : '';

    if ($embedUrl === '') {
        $field['message'] = '<em>' . esc_html__('Add a form hash above and save to see the embed code.', 'flynt') . '</em>';

        return $field;
    }

    $field['message'] = sprintf(
        '<p>%s</p><textarea readonly rows="4" style="width:100%%;font-family:monospace;font-size:11px" onclick="this.select()">%s</textarea>',
        esc_html__('Built from the fields above — this is what gets embedded on the page. Updates when you save.', 'flynt'),
        // Decode the &#038; that esc_url() writes, so the copied snippet also
        // works where it is not parsed as HTML.
        esc_textarea(html_entity_decode(FundraisingBox::embedScript($embedUrl), ENT_QUOTES))
    );

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
                'label' => __('Chimpanzee Info', 'flynt'),
                'name' => 'infoTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
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
                'label' => __('Form', 'flynt'),
                'name' => 'formTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
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
                'label' => __('Sponsored Chimpanzee', 'flynt'),
                'instructions' => __('The option this chimpanzee corresponds to in the form\'s chimpanzee dropdown, exactly as FundraisingBox spells it, e.g. <code>Mawa</code>. Leave empty to use this chimpanzee\'s name.', 'flynt'),
                'name' => 'fbCustomFieldValue',
                'type' => 'text',
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Preselect country', 'flynt'),
                'instructions' => __('Open the country dropdown in the donor\'s address on a set country. Donors can still choose another one.', 'flynt'),
                'name' => 'fbPreselectCountry',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 0,
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Country', 'flynt'),
                'name' => 'fbCountry',
                'type' => 'select',
                'choices' => FundraisingBox::countryChoices(),
                'default_value' => 'DE',
                'allow_null' => 0,
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'fbPreselectCountry',
                            'operator' => '==',
                            'value' => 1,
                        ],
                    ],
                ],
                'wrapper' => [
                    'width' => 50,
                ],
            ],
            [
                'label' => __('Generated embed code', 'flynt'),
                'instructions' => __('Copy the generated embed code into the Full embed code (advanced) field below.', 'flynt'),
                'name' => 'fbPreview',
                'type' => 'message',
                'message' => '',
                'new_lines' => '',
                'escape_html' => 0,
            ],
            [
                'label' => __('Full embed code (advanced)', 'flynt'),
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
