<?php

namespace Flynt\Components\BlockFormRootsShoots;

const ACTION = 'rootsShootsSignup';
const RECIPIENT = 'rootsandshoots@janegoodall.de';
const POST_TYPE = 'roots-shoots-signup';
const RATE_LIMIT = 5; // Submissions per IP per hour.

/**
 * Form definition: the single source for the rendered form, server-side
 * validation and the notification email.
 *
 * Field keys: type (text|email|tel|date|number|textarea|radio|checkbox),
 * required, width (half|full), autocomplete, choices, default.
 * A section with a `condition` [field, value] is only shown and validated
 * when that field has that value.
 */
function getSections()
{
    $yesNo = ['ja' => 'Ja', 'nein' => 'Nein'];

    return [
        'person' => [
            'title' => 'Angaben zu deiner Person',
            'fields' => [
                'firstName' => ['label' => 'Vorname', 'type' => 'text', 'required' => true, 'autocomplete' => 'given-name'],
                'lastName' => ['label' => 'Nachname', 'type' => 'text', 'required' => true, 'autocomplete' => 'family-name'],
                'email' => ['label' => 'E-Mail', 'type' => 'email', 'required' => true, 'autocomplete' => 'email'],
                'phone' => ['label' => 'Telefonnummer', 'type' => 'tel', 'autocomplete' => 'tel'],
                'birthdate' => ['label' => 'Geburtsdatum', 'type' => 'date', 'autocomplete' => 'bday'],
                'over18' => ['label' => 'Bist du über 18?', 'type' => 'radio', 'required' => true, 'choices' => $yesNo],
                'street' => ['label' => 'Straße', 'type' => 'text', 'autocomplete' => 'street-address'],
                'zip' => ['label' => 'PLZ', 'type' => 'text', 'required' => true, 'autocomplete' => 'postal-code'],
                'city' => ['label' => 'Stadt', 'type' => 'text', 'required' => true, 'autocomplete' => 'address-level2'],
                'country' => ['label' => 'Land', 'type' => 'text', 'required' => true, 'autocomplete' => 'country-name', 'default' => 'Deutschland'],
            ],
        ],
        'guardian' => [
            'title' => 'Volljährige Vertrauensperson',
            'description' => 'Solltest du nicht über 18 Jahre alt sein, trage hier bitte die Daten einer volljährigen Vertrauensperson ein.',
            'condition' => ['over18', 'nein'],
            'fields' => [
                'guardianFirstName' => ['label' => 'Vorname', 'type' => 'text', 'required' => true],
                'guardianLastName' => ['label' => 'Nachname', 'type' => 'text', 'required' => true],
                'guardianEmail' => ['label' => 'E-Mail', 'type' => 'email', 'required' => true],
                'guardianBirthdate' => ['label' => 'Geburtsdatum', 'type' => 'date'],
                'guardianRelation' => ['label' => 'Verhältnis zu dir', 'type' => 'text', 'required' => true, 'width' => 'full'],
            ],
        ],
        'group' => [
            'title' => 'Eure Gruppe',
            'fields' => [
                'memberCount' => ['label' => 'Wie viele Gruppenmitglieder plant ihr?', 'type' => 'number'],
                'groupName' => ['label' => 'Wie soll eure Roots & Shoots Gruppe heißen?', 'type' => 'text'],
                'supporter' => ['label' => 'Ihr werdet von eurer Schule oder einem anderen Verein bei Roots & Shoots unterstützt? Dann sagt uns bitte, wer euch dabei begleitet.', 'type' => 'text', 'width' => 'full'],
                'topics' => ['label' => 'Für welches Thema wollt ihr euch engagieren?', 'type' => 'checkbox', 'width' => 'full', 'choices' => ['mensch' => 'Mensch', 'tier' => 'Tier', 'umwelt' => 'Umwelt']],
                'idea' => ['label' => 'Habt ihr bereits eine konkrete Idee für euer Projekt? Nein? Wir helfen gerne! Ja? Erklärt eure Idee kurz:', 'type' => 'textarea', 'width' => 'full'],
                'openForMembers' => ['label' => 'Ist euer Projekt offen für neue Mitglieder? Wir vermitteln gerne.', 'type' => 'radio', 'width' => 'full', 'choices' => $yesNo],
            ],
        ],
    ];
}

add_filter('Flynt/addComponentData?name=BlockFormRootsShoots', function ($data) {
    $data['sections'] = getSections();
    $data['action'] = ACTION;
    $data['actionUrl'] = admin_url('admin-post.php');
    // Set by the no-JS redirect fallback.
    $data['status'] = sanitize_key($_GET['rs-signup'] ?? '');
    return $data;
});

add_action('admin_post_nopriv_' . ACTION, __NAMESPACE__ . '\\handleSubmission');
add_action('admin_post_' . ACTION, __NAMESPACE__ . '\\handleSubmission');

function handleSubmission()
{
    $input = wp_unslash($_POST);

    // Honeypot: bots fill every field. Pretend success, send nothing.
    if (!empty($input['website'])) {
        respond(true);
    }

    // No nonce: pages are cached on WP Engine, so a nonce in the markup
    // would expire for anonymous visitors. Throttle per IP instead.
    $rateKey = 'rs_signup_' . md5($_SERVER['REMOTE_ADDR'] ?? '');
    $count = (int) get_transient($rateKey);
    if ($count >= RATE_LIMIT) {
        respond(false, [], 'Zu viele Anfragen. Bitte versucht es später noch einmal.');
    }

    [$values, $errors] = validate($input);

    if (empty($input['consent'])) {
        $errors['consent'] = 'Bitte bestätigt die Einverständniserklärung.';
    }

    if ($errors) {
        respond(false, $errors, 'Bitte prüft die markierten Felder.');
    }

    set_transient($rateKey, $count + 1, HOUR_IN_SECONDS);

    $body = buildEmailBody($values);
    $name = trim($values['firstName'] . ' ' . $values['lastName']);
    $subject = 'Roots & Shoots Gruppenanmeldung: ' . ($values['groupName'] ?: $name);

    $postId = wp_insert_post([
        'post_type' => POST_TYPE,
        'post_status' => 'private',
        'post_title' => $subject,
        'post_content' => $body,
    ]);

    $sent = wp_mail(
        apply_filters('Flynt/BlockFormRootsShoots/recipient', RECIPIENT),
        $subject,
        $body,
        [
            'Content-Type: text/plain; charset=UTF-8',
            sprintf('Reply-To: %s <%s>', $name, $values['email']),
        ]
    );

    if (!is_wp_error($postId) && $postId) {
        update_post_meta($postId, 'mailSent', $sent ? 1 : 0);
    }

    if (!$sent) {
        error_log('BlockFormRootsShoots: notification email failed for signup ' . (int) $postId);
    }

    // The signup is safe once stored, even if the mail failed.
    if (!$sent && (is_wp_error($postId) || !$postId)) {
        respond(false, [], 'Die Anmeldung konnte leider nicht gesendet werden. Bitte schreibt uns direkt an ' . RECIPIENT . '.');
    }

    respond(true);
}

/**
 * Sanitize every defined field and collect errors. Fields in a section whose
 * condition is not met are skipped.
 */
function validate(array $input)
{
    $values = [];
    $errors = [];

    foreach (getSections() as $section) {
        if (!empty($section['condition'])) {
            [$conditionField, $conditionValue] = $section['condition'];
            if (($values[$conditionField] ?? '') !== $conditionValue) {
                continue;
            }
        }

        foreach ($section['fields'] as $key => $field) {
            $raw = $input[$key] ?? '';
            $value = sanitizeValue($raw, $field);

            if (!empty($field['required']) && ($value === '' || $value === [])) {
                $errors[$key] = 'Pflichtfeld';
            } elseif ($field['type'] === 'email' && $value !== '' && !is_email($value)) {
                $errors[$key] = 'Bitte gebt eine gültige E-Mail-Adresse ein.';
            }

            $values[$key] = $value;
        }
    }

    return [$values, $errors];
}

function sanitizeValue($raw, array $field)
{
    switch ($field['type']) {
        case 'checkbox':
            $raw = is_array($raw) ? $raw : [];
            return array_values(array_intersect(array_map('strval', $raw), array_keys($field['choices'])));
        case 'radio':
            return is_string($raw) && isset($field['choices'][$raw]) ? $raw : '';
        case 'email':
            return is_string($raw) ? sanitize_email($raw) : '';
        case 'textarea':
            return is_string($raw) ? sanitize_textarea_field($raw) : '';
        case 'date':
            return is_string($raw) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw) ? $raw : '';
        case 'number':
            return is_numeric($raw) ? (string) absint($raw) : '';
        default:
            return is_string($raw) ? sanitize_text_field($raw) : '';
    }
}

/**
 * Plain-text email listing every answer, grouped by section.
 */
function buildEmailBody(array $values)
{
    $lines = ['Neue Roots & Shoots Gruppenanmeldung über janegoodall.de', ''];

    foreach (getSections() as $sectionKey => $section) {
        $fields = array_intersect_key($section['fields'], $values);
        if (!$fields) {
            continue;
        }

        $lines[] = mb_strtoupper($section['title']);
        foreach ($fields as $key => $field) {
            $value = formatValue($values[$key], $field) ?: '–';
            // Long questions read better with the answer on its own line.
            $lines[] = mb_strlen($field['label']) > 40
                ? $field['label'] . "\n" . $value . "\n"
                : $field['label'] . ': ' . $value;
        }
        $lines[] = '';
    }

    $lines[] = 'Einverständniserklärung: gelesen und einverstanden';
    $lines[] = 'Gesendet: ' . wp_date('d.m.Y H:i');

    return implode("\n", $lines);
}

function formatValue($value, array $field)
{
    if ($field['type'] === 'checkbox') {
        return implode(', ', array_map(function ($choice) use ($field) {
            return $field['choices'][$choice];
        }, $value));
    }
    if ($field['type'] === 'radio' && $value !== '') {
        return $field['choices'][$value];
    }
    if ($field['type'] === 'date' && $value !== '') {
        return wp_date('d.m.Y', strtotime($value));
    }
    return $value;
}

/**
 * JSON for the Alpine fetch, redirect back to the page otherwise.
 */
function respond($success, array $errors = [], $message = '')
{
    $wantsJson = strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;

    if ($wantsJson) {
        $payload = ['errors' => (object) $errors, 'message' => $message];
        $success ? wp_send_json_success($payload) : wp_send_json_error($payload, 422);
    }

    $redirect = add_query_arg('rs-signup', $success ? 'success' : 'error', wp_get_referer() ?: home_url('/'));
    wp_safe_redirect($redirect . '#rs-signup');
    exit;
}

function getACFLayout()
{
    return [
        'name' => 'BlockFormRootsShoots',
        'label' => __('Block: Form Roots & Shoots Signup', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Text', 'flynt'),
                'name' => 'textTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
                'default_value' => 'Roots & Shoots Gruppenanmeldung',
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
                'label' => __('Intro', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
                'default_value' => '<p>Wir freuen uns darauf, euch bei der Verwirklichung eurer Ideen zu helfen. Bitte füllt das folgende Formular so detailliert wie möglich aus und helft uns damit, eure Ideen besser zu verstehen. Es kann sein, dass wir zum Zeitpunkt eurer Einsendung ein hohes Aufkommen an Anfragen haben und ihr nicht sofort eine Antwort erhaltet. Wir melden uns aber schnellstmöglich bei euch zurück.</p>',
            ],
            [
                'label' => __('Form', 'flynt'),
                'name' => 'formTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Consent Text', 'flynt'),
                'instructions' => __('Label of the required consent checkbox. Link the consent declaration here.', 'flynt'),
                'name' => 'consentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'delay' => 1,
                'default_value' => 'Ich habe die <a href="https://janegoodall.de/roots-shoots/">Einverständniserklärung</a> unter der Roots & Shoots Gruppenanmeldung gelesen und bin einverstanden.',
            ],
            [
                'label' => __('Button Label', 'flynt'),
                'name' => 'buttonLabel',
                'type' => 'text',
                'default_value' => 'Anmeldung absenden',
                'wrapper' => ['width' => 50],
            ],
            [
                'label' => __('Confirmation', 'flynt'),
                'name' => 'confirmationTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Confirmation Title', 'flynt'),
                'name' => 'successTitle',
                'type' => 'text',
                'default_value' => 'Vielen Dank für eure Anmeldung!',
            ],
            [
                'label' => __('Confirmation Text', 'flynt'),
                'instructions' => __('Shown in place of the form after a successful submission.', 'flynt'),
                'name' => 'successHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
                'default_value' => '<p>Wir haben eure Angaben erhalten und melden uns schnellstmöglich bei euch. Wir freuen uns auf euch!</p>',
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
                    [
                        'label' => '',
                        'name' => 'recipientInfo',
                        'type' => 'message',
                        'message' => sprintf(__('Submissions are emailed to %s and stored under R&S Signups.', 'flynt'), RECIPIENT),
                    ],
                    [
                        'label' => __('Theme', 'flynt'),
                        'name' => 'theme',
                        'type' => 'select',
                        'default_value' => 'offWhite',
                        'choices' => [
                            'offWhite' => __('Off White', 'flynt'),
                            'beige' => __('Beige', 'flynt'),
                            'moss' => __('Moss', 'flynt'),
                            'dark-green' => __('Dark Green', 'flynt'),
                        ],
                    ],
                ],
            ],
        ],
    ];
}
