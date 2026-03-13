<?php

use Flynt\Utils\Options;

Options::addTranslatable('Articles', [
    [
        'label' => __('Author Label', 'flynt'),
        'name' => 'authorLabel',
        'type' => 'text',
        'default_value' => 'Ein Artikel von',
        'wrapper' => ['width' => '50'],
    ],
    [
        'label' => __('Back Button Label', 'flynt'),
        'name' => 'backButtonLabel',
        'type' => 'text',
        'default_value' => 'Zurück',
        'wrapper' => ['width' => '50'],
    ],
]);
