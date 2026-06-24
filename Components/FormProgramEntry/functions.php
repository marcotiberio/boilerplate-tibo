<?php

namespace Flynt\Components\FormProgramEntry;

use Flynt\ProgramEntry;

function getACFLayout()
{
    return [
        'name' => 'formProgramEntry',
        'label' => __('Form Program Entry', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
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
                'label' => __('Submit button label', 'flynt'),
                'name' => 'submitLabel',
                'type' => 'text',
                'default_value' => __('Submit entry', 'flynt'),
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Privacy consent label', 'flynt'),
                'instructions' => __('Shown next to the required consent checkbox. Use a link to your privacy policy.', 'flynt'),
                'name' => 'consentLabel',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Success message', 'flynt'),
                'name' => 'successHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Form fields', 'flynt'),
                'name' => 'fieldsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'fields',
                'type' => 'group',
                'instructions' => __('Labels and placeholders for each input. The set of fields is fixed so submissions stay in sync with storage, geocoding and validation.', 'flynt'),
                'layout' => 'block',
                'sub_fields' => [
                    // text
                    [
                        'label' => __('Name — label', 'flynt'),
                        'name' => 'nameLabel',
                        'type' => 'text',
                        'default_value' => __('Name', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Name — placeholder', 'flynt'),
                        'name' => 'namePlaceholder',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    // email
                    [
                        'label' => __('Email — label', 'flynt'),
                        'name' => 'emailLabel',
                        'type' => 'text',
                        'default_value' => __('Email', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Email — placeholder', 'flynt'),
                        'name' => 'emailPlaceholder',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    // phone
                    [
                        'label' => __('Phone — label', 'flynt'),
                        'name' => 'phoneLabel',
                        'type' => 'text',
                        'default_value' => __('Phone', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Phone — placeholder', 'flynt'),
                        'name' => 'phonePlaceholder',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    // textarea
                    [
                        'label' => __('Description — label', 'flynt'),
                        'name' => 'descriptionLabel',
                        'type' => 'text',
                        'default_value' => __('Description', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Description — placeholder', 'flynt'),
                        'name' => 'descriptionPlaceholder',
                        'type' => 'text',
                        'wrapper' => ['width' => 50],
                    ],
                    // single choice
                    [
                        'label' => __('Category — label', 'flynt'),
                        'name' => 'categoryLabel',
                        'type' => 'text',
                        'default_value' => __('Category', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    // multiple choice
                    [
                        'label' => __('Themes — label', 'flynt'),
                        'name' => 'themesLabel',
                        'type' => 'text',
                        'default_value' => __('Themes', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    // address
                    [
                        'label' => __('Address — label', 'flynt'),
                        'name' => 'addressLabel',
                        'type' => 'text',
                        'default_value' => __('Address', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                    [
                        'label' => __('Address — placeholder', 'flynt'),
                        'name' => 'addressPlaceholder',
                        'type' => 'text',
                        'default_value' => __('Street, city', 'flynt'),
                        'wrapper' => ['width' => 50],
                    ],
                ],
            ],
        ],
    ];
}

// Inject the REST endpoint, a fresh nonce and the shared choice lists so the
// Alpine form can render and submit without a separate config request.
add_filter('Flynt/addComponentData?name=FormProgramEntry', function ($data) {
    $config = ProgramEntry\getConfig();
    $data['categories'] = $config['categories'];
    $data['themes'] = $config['themes'];
    $data['restUrl'] = esc_url_raw(rest_url('looptopia/v1/program-entry'));
    $data['nonce'] = wp_create_nonce(ProgramEntry\NONCE_ACTION);
    // Keeps the REST request authenticated as the same user the nonce above was
    // created for. Without it WordPress runs the request as user 0 when a login
    // cookie is present, breaking our user-bound nonce check.
    $data['restNonce'] = wp_create_nonce('wp_rest');
    return $data;
});
