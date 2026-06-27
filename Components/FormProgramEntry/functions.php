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
            ],
            [
                'label' => __('Section intro — Organisation', 'flynt'),
                'name' => 'introOrg',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Section intro — Angebot', 'flynt'),
                'name' => 'introOffer',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Section intro — Details', 'flynt'),
                'name' => 'introDetails',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Section intro — Veranstaltung', 'flynt'),
                'name' => 'introEvent',
                'type' => 'wysiwyg',
                'tabs' => 'visual',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => __('Submit button label', 'flynt'),
                'name' => 'submitLabel',
                'type' => 'text',
                'default_value' => __('Anmeldeformular absenden', 'flynt'),
                'wrapper' => ['width' => 50],
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
                'label' => __('Consent & links', 'flynt'),
                'name' => 'consentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Teilnahmekriterien link', 'flynt'),
                'name' => 'criteriaLink',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Nutzungsbedingungen link', 'flynt'),
                'name' => 'termsLink',
                'type' => 'link',
                'return_format' => 'array',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Newsletter consent label', 'flynt'),
                'name' => 'newsletterLabel',
                'type' => 'text',
                'default_value' => __('Ja, ich möchte den Circular Berlin Newsletter abonnieren', 'flynt'),
            ],
        ],
    ];
}

// Inject the REST endpoint, fresh nonces and the shared choice lists so the
// Alpine form can render and submit without a separate config request.
add_filter('Flynt/addComponentData?name=FormProgramEntry', function ($data) {
    $data['config'] = ProgramEntry\getConfig();
    $data['restUrl'] = esc_url_raw(rest_url('looptopia/v1/program-entry'));
    $data['nonce'] = wp_create_nonce(ProgramEntry\NONCE_ACTION);
    // Keeps the REST request authenticated as the same user the nonce above was
    // created for. Without it WordPress runs the request as user 0 when a login
    // cookie is present, breaking our user-bound nonce check.
    $data['restNonce'] = wp_create_nonce('wp_rest');
    return $data;
});
