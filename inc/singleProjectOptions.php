<?php

use Flynt\Utils\Options;

Options::addTranslatable('SingleProject', [
    [
        'label' => __('Back Label', 'flynt'),
        'instructions' => __('Label for the back button on a single project page.', 'flynt'),
        'name' => 'backLabel',
        'type' => 'text',
        'default_value' => __('Go back', 'flynt'),
    ],
]);
