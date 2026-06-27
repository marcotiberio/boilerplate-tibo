<?php

/**
 * ACF field group for the Program Entry CPT.
 *
 * Fields the client reviews/edits in wp-admin before publishing. Mirrors the
 * public form (Components/FormProgramEntry) and the intake sheet, grouped into
 * the same sections. Choice lists come from ProgramEntry\getConfig().
 */

use ACFComposer\ACFComposer;
use Flynt\ProgramEntry;

add_action('Flynt/afterRegisterComponents', function () {
    $config = ProgramEntry\getConfig();

    ACFComposer::registerFieldGroup([
        'name' => 'programEntryDetails',
        'title' => __('Submission Details', 'flynt'),
        'style' => 'default',
        'position' => 'normal',
        'fields' => [
            // ---- Section 1: Organisation ----
            [
                'label' => __('Organisation', 'flynt'),
                'name' => 'orgTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Name der Organisation', 'flynt'),
                'name' => 'orgName',
                'type' => 'text',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Kontaktperson', 'flynt'),
                'name' => 'contactPerson',
                'type' => 'text',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Mailadresse', 'flynt'),
                'instructions' => __('Privat — nicht öffentlich sichtbar.', 'flynt'),
                'name' => 'contactEmail',
                'type' => 'email',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Logo der Organisation', 'flynt'),
                'name' => 'orgLogo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png,svg',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Website', 'flynt'),
                'name' => 'website',
                'type' => 'url',
                'wrapper' => ['width' => 33],
            ],
            [
                'label' => __('Instagram', 'flynt'),
                'name' => 'instagram',
                'type' => 'url',
                'wrapper' => ['width' => 33],
            ],
            [
                'label' => __('LinkedIn', 'flynt'),
                'name' => 'linkedin',
                'type' => 'url',
                'wrapper' => ['width' => 33],
            ],

            // ---- Section 2: Angebot (allgemein) ----
            [
                'label' => __('Angebot', 'flynt'),
                'name' => 'offerTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Thema — Welche Ziele verfolgt euer Programm?', 'flynt'),
                'name' => 'goals',
                'type' => 'checkbox',
                'choices' => $config['goals'],
                'required' => 1,
            ],
            [
                'label' => __('Sektor', 'flynt'),
                'name' => 'sectors',
                'type' => 'checkbox',
                'choices' => $config['sectors'],
                'required' => 1,
            ],
            [
                'label' => __('Ist eine Anmeldung erforderlich?', 'flynt'),
                'name' => 'registration',
                'type' => 'radio',
                'choices' => $config['registration'],
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Anmeldelink', 'flynt'),
                'name' => 'registrationLink',
                'type' => 'url',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'registration', 'operator' => '==', 'value' => 'anmeldung'],
                    ],
                ],
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Fallen für die Teilnahme Kosten an?', 'flynt'),
                'name' => 'costs',
                'type' => 'radio',
                'choices' => $config['costs'],
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Preis', 'flynt'),
                'name' => 'price',
                'type' => 'text',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'costs', 'operator' => '==', 'value' => 'ja'],
                    ],
                ],
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Link zur Bezahlung / Buchung', 'flynt'),
                'name' => 'paymentLink',
                'type' => 'url',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'costs', 'operator' => '==', 'value' => 'ja'],
                    ],
                ],
                'wrapper' => ['width' => 25],
            ],

            // ---- Section 3: Details zum Angebot ----
            [
                'label' => __('Details', 'flynt'),
                'name' => 'detailsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Beschreibungstext des Angebots', 'flynt'),
                'name' => 'description',
                'type' => 'textarea',
                'rows' => 6,
                'required' => 1,
            ],
            [
                'label' => __('Sprache der Veranstaltung', 'flynt'),
                'name' => 'language',
                'type' => 'text',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Art des Programmpunkts', 'flynt'),
                'name' => 'programTypes',
                'type' => 'checkbox',
                'choices' => $config['programTypes'],
                'required' => 1,
            ],
            [
                'label' => __('Format', 'flynt'),
                'name' => 'format',
                'type' => 'radio',
                'choices' => $config['format'],
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Zielgruppe', 'flynt'),
                'name' => 'audiences',
                'type' => 'checkbox',
                'choices' => $config['audiences'],
            ],

            // ---- Section 4: Veranstaltung ----
            [
                'label' => __('Veranstaltung', 'flynt'),
                'name' => 'eventTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Titel der Veranstaltung', 'flynt'),
                'instructions' => __('Wird als Titel des Eintrags verwendet.', 'flynt'),
                'name' => 'eventTitle',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'label' => __('Kurzer Introtext (1 Satz)', 'flynt'),
                'name' => 'intro',
                'type' => 'text',
                'required' => 1,
            ],
            [
                'label' => __('Titelbild', 'flynt'),
                'name' => 'featuredImage',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'mime_types' => 'jpg,jpeg,png',
                'required' => 1,
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Weitere Fotos (optional)', 'flynt'),
                'name' => 'gallery',
                'type' => 'gallery',
                'mime_types' => 'jpg,jpeg,png',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Bildnachweise / Credits', 'flynt'),
                'name' => 'credits',
                'type' => 'text',
            ],
            [
                'label' => __('Wann soll eure Veranstaltung stattfinden?', 'flynt'),
                'name' => 'dateMode',
                'type' => 'radio',
                'choices' => $config['dateMode'],
                'required' => 1,
            ],
            [
                'label' => __('Datum von', 'flynt'),
                'name' => 'dateFrom',
                'type' => 'date_picker',
                'display_format' => 'd.m.Y',
                'return_format' => 'Y-m-d',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'dateMode', 'operator' => '==', 'value' => 'wunsch'],
                    ],
                ],
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Datum bis', 'flynt'),
                'name' => 'dateTo',
                'type' => 'date_picker',
                'display_format' => 'd.m.Y',
                'return_format' => 'Y-m-d',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'dateMode', 'operator' => '==', 'value' => 'wunsch'],
                    ],
                ],
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Startzeit', 'flynt'),
                'name' => 'timeStart',
                'type' => 'time_picker',
                'display_format' => 'H:i',
                'return_format' => 'H:i',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'dateMode', 'operator' => '==', 'value' => 'wunsch'],
                    ],
                ],
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Ende', 'flynt'),
                'name' => 'timeEnd',
                'type' => 'time_picker',
                'display_format' => 'H:i',
                'return_format' => 'H:i',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'dateMode', 'operator' => '==', 'value' => 'wunsch'],
                    ],
                ],
                'wrapper' => ['width' => 25],
            ],
            [
                'label' => __('Wo soll euer Angebot stattfinden?', 'flynt'),
                'name' => 'locationMode',
                'type' => 'radio',
                'choices' => $config['locationMode'],
                'required' => 1,
            ],
            [
                'label' => __('Straße + Hausnummer', 'flynt'),
                'name' => 'street',
                'type' => 'text',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'locationMode', 'operator' => '==', 'value' => 'eigen'],
                    ],
                ],
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Postleitzahl', 'flynt'),
                'name' => 'postalCode',
                'type' => 'text',
                'conditional_logic' => [
                    [
                        ['fieldPath' => 'locationMode', 'operator' => '==', 'value' => 'eigen'],
                    ],
                ],
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Map-Pin', 'flynt'),
                'instructions' => __('Wird beim Speichern aus Straße + PLZ ermittelt. Pin zum Feinjustieren ziehen.', 'flynt'),
                'name' => 'location',
                'type' => 'google_map',
                'height' => 400,
                'zoom' => 13,
            ],
            [
                'label' => __('Hinweise zur klimafreundlichen Anreise', 'flynt'),
                'name' => 'mobilityInfo',
                'type' => 'textarea',
                'rows' => 3,
            ],
            [
                'label' => __('Bietet euer Veranstaltungsort Möglichkeiten für weitere Programmpunkte?', 'flynt'),
                'instructions' => __('Nur für interne Planung.', 'flynt'),
                'name' => 'venueOpenForOthers',
                'type' => 'true_false',
                'ui' => 1,
            ],
            [
                'label' => __('Info über Barrierefreiheit', 'flynt'),
                'name' => 'accessibility',
                'type' => 'checkbox',
                'choices' => $config['accessibility'],
                'required' => 1,
            ],

            // ---- Section 5: Intern & Zustimmung ----
            [
                'label' => __('Intern & Zustimmung', 'flynt'),
                'name' => 'consentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Möchtet ihr euch für eine Programmförderung bewerben?', 'flynt'),
                'instructions' => __('Nur intern.', 'flynt'),
                'name' => 'fundingInterest',
                'type' => 'true_false',
                'ui' => 1,
            ],
            [
                'label' => __('Teilnahmekriterien akzeptiert', 'flynt'),
                'name' => 'acceptCriteria',
                'type' => 'true_false',
                'ui' => 1,
                'wrapper' => ['width' => 33],
            ],
            [
                'label' => __('Nutzungsbedingungen akzeptiert', 'flynt'),
                'name' => 'acceptTerms',
                'type' => 'true_false',
                'ui' => 1,
                'wrapper' => ['width' => 33],
            ],
            [
                'label' => __('Newsletter abonniert', 'flynt'),
                'name' => 'newsletter',
                'type' => 'true_false',
                'ui' => 1,
                'wrapper' => ['width' => 33],
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
