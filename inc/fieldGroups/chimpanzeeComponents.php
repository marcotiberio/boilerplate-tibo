<?php

use ACFComposer\ACFComposer;

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
                'type' => 'text',
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
