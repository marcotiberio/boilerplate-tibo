<?php

/**
 * ACF field group for the Program Entry CPT.
 *
 * These are the fields the client reviews/edits in wp-admin before publishing.
 * They mirror the public form (see Components/FormProgramEntry) and the demo
 * field types requested: text, textarea, email, phone, single + multiple choice.
 */

use ACFComposer\ACFComposer;
use Flynt\ProgramEntry;

add_action('Flynt/afterRegisterComponents', function () {
    $config = ProgramEntry\getConfig();

    ACFComposer::registerFieldGroup([
        'name' => 'programEntryDetails',
        'title' => __('Submission Details', 'flynt'),
        'style' => 'default',
        'position' => 'acf_after_title',
        'fields' => [
            [
                'label' => __('Submission', 'flynt'),
                'name' => 'submissionTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Contact name', 'flynt'),
                'name' => 'contactName',
                'type' => 'text',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Email', 'flynt'),
                'instructions' => __('Private — not shown on the public map.', 'flynt'),
                'name' => 'contactEmail',
                'type' => 'email',
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Phone', 'flynt'),
                'instructions' => __('Private — not shown on the public map.', 'flynt'),
                'name' => 'contactPhone',
                'type' => 'text',
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Description', 'flynt'),
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => __('Public description shown in the map popup.', 'flynt'),
            ],
            [
                'label' => __('Category', 'flynt'),
                'instructions' => __('Single choice.', 'flynt'),
                'name' => 'category',
                'type' => 'radio',
                'choices' => $config['categories'],
                'layout' => 'horizontal',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Themes', 'flynt'),
                'instructions' => __('Multiple choice.', 'flynt'),
                'name' => 'themes',
                'type' => 'checkbox',
                'choices' => $config['themes'],
                'layout' => 'vertical',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Location', 'flynt'),
                'name' => 'locationTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Address', 'flynt'),
                'instructions' => __('Free-text address as submitted. Saving with an empty pin below will auto-geocode this.', 'flynt'),
                'name' => 'address',
                'type' => 'text',
            ],
            [
                'label' => __('Map pin', 'flynt'),
                'instructions' => __('Auto-filled from the address on submission. Drag the pin to fine-tune before publishing.', 'flynt'),
                'name' => 'location',
                'type' => 'google_map',
                'height' => 400,
                'zoom' => 13,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => ProgramEntry\POST_TYPE,
                ],
            ],
        ],
    ]);
});
